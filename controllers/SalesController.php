<?php

namespace app\controllers;

use Yii;
use app\models\Sales;
use app\models\SalesDetail;
use app\models\SalesSearch;
use app\models\Stock;
use app\models\Vendor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\components\MyController;
use kartik\mpdf\Pdf;

/**
 * SalesController implements the CRUD actions for Sales model.
 */
class SalesController extends MyController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'submit-sales', 'print-surat-jalan', 'invoice', 'update', 'delete', 'surat-jalan'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Sales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sales model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SalesDetail::find()->where(['sales_id' => $id]),
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Sales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sales();
        $vendor = Vendor::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'vendor' => $vendor,
            ]);
        }
    }

    /**
     * Generate code for sales code
     * 
     */

    private function generateSalesCode() {
        $currDate = date('Y-m-d');
        $sales = Sales::find()->where([
            'DATE(sales_date)' => $currDate
        ])->orderBy('sales_date DESC')->one();
        $prevIndex = 0;
        if ($sales) {
            $prevIndex = (int) substr($sales->code, 8);
        }
        $newIndex = $prevIndex + 1;
        $code = "SO" . date('dmy') . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        
        return $code;
    }

    public function actionSubmitSales()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // eg. SO00001 SO1104220001
        $out = [
            'success' => false,
        ];

        if (
            isset($_POST['vendor_id']) &&
            isset($_POST['sales_date']) &&
            isset($_POST['total']) &&
            isset($_POST['items'])
        ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $sales = new Sales();
                $sales->vendor_id = $_POST['vendor_id'];
                $sales->code = $this->generateSalesCode();
                $sales->sales_date = $_POST['sales_date'] . ' ' . date('H:i:s');
                $sales->total = $_POST['total'];
                if ($sales->validate() && $sales->save()) {
                    $data = json_decode($_POST['items']);
                    foreach ($data as $item) {
                        $salesDetail = new SalesDetail();
                        $salesDetail->sales_id = $sales->id;
                        $salesDetail->sampah_id = $item->id;
                        $salesDetail->amount_kg = $item->weight;
                        $salesDetail->total_price = $item->weight * $item->harga;
                        if ($salesDetail->validate()) {
                            if ($salesDetail->save()) {
                                $stock = new Stock();
                                $stock->idstock = (string) round(microtime(true) * 1000);
                                $stock->idjnssampah = $item->id;
                                $stock->nilai = $item->weight;
                                $stock->jnsstock = 'OUT';
                                $stock->tgl = $_POST['sales_date'];
                                if ($stock->validate()) {
                                    $stock->save();
                                    $out = [
                                        'success' => true,
                                        'id' => $sales->id,
                                    ];
                                }
                            }
                        }
                    }
                    $transaction->commit();     
                }
            } catch (\Exception $e) {
                $transaction->rollback();
            }
        }

        return $out;
    }

    /**
     * Letter to print
     */
    public function actionPrintSuratJalan($id)
    {

        $model = $this->findModel($id);
        $code = $this->generateSuratJalanCode();

        $content = "";
        $arrPrintCopy = Yii::$app->params['print_copy'];
        foreach ($arrPrintCopy as $item) {
            if ($content == "") {
                $content = $this->renderPartial('report', [
                    'model' => $model,
                    'code' => $code,
                    'item' => $item
                ]); 
            }else {
                $pageBreak = '<div class="page-break"></div>';
                $content = $content . $pageBreak. $this->renderPartial('report', [
                    'model' => $model,
                    'code' => $code,
                    'item' => $item
                ]); 
            }
              
        }
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            'marginTop' => 5,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
            'cssInline' => '
                .kv-heading-1{font-size:18px}
                @media all {
                    .page-break	{ display: none; }
                }
                @media print {
                    .page-break	{ display: block; page-break-before: always; }
                }
            ',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            // 'methods' => [ 
            //     'SetHeader'=>['Krajee Report Header'], 
            //     'SetFooter'=>['{PAGENO}'],
            // ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
        // if ($model) {
        //     $this->layout = 'empty';

        //     return $this->render('report', [
        //         'model' => $model,
        //         'code' => $code
        //     ]);
        // }
    }

    public function actionSuratJalan($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            if ($model->load(Yii::$app->request->post())) {
                $model->generated_date_surat_jalan = $model->sales_date;
                if (!$model->surat_jalan_code) {
                    $model->surat_jalan_code = $this->generateSuratJalanCode();
                }
                if ($model->save()) {
                    return $this->redirect(['print-surat-jalan', 'id' => $model->id]);
                }
            }

            return $this->render('surat-jalan', [
                'model' => $model,
            ]);
        } else {
            // return $this->redirect(['index']);
        }
    }

    private function generateSuratJalanCode()
    {
        $currMonth = date('n');
        $currYear = date('Y');
        $strWhere = "MONTH(sales_date) = '$currMonth' AND YEAR(sales_date) = '$currYear' 
        AND surat_jalan_code IS NOT null";
        $sales = Sales::find()->where($strWhere)->orderBy('sales_date DESC')->one();
        $prevIndex = 0;
        if ($sales) {
            $prevIndex = (int) substr($sales->surat_jalan_code, 0, 3);
        }
        $newIndex = $prevIndex + 1;

        $code = str_pad($newIndex, 3, '0', STR_PAD_LEFT) . "/" . date('m') . "/ETS/" . date('Y');
        return $code;
    }

    /**
     * Letter to print
     */
    public function actionInvoice($id)
    {

        $model = $this->findModel($id);
        if ($model) {
            $this->layout = 'empty';

            return $this->render('invoice', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sales model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        try {
            $this->findModel($id)->delete();
        } catch (\yii\db\IntegrityException  $e) {
            Yii::$app->session->setFlash('error', "Data Tidak Dapat Dihapus Karena Dipakai Modul Lain");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Sales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
