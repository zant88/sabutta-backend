<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\models\InvoiceDetail;
use app\models\InvoiceSearch;
use app\models\Sales;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\MyController;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends MyController
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
                        'actions' => [
                            'index', 'view', 'create', 'print-invoice', 
                            'get-sj-by-vendor', 'update', 'delete'
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();
        $vendorData = (new \yii\db\Query())
            ->select(['vendor.id as id', 'vendor.name as text'])
            ->from('sales')
            ->leftJoin('vendor', 'sales.vendor_id=vendor.id')
            ->where(['invoiced'=>0])
            ->distinct()
            ->all();
        $vendorList = [];
        foreach ($vendorData as $item) {
            $vendorList[$item['id']] = $item['text'];
        }
        if (
            $model->load(Yii::$app->request->post()) && 
            isset($_POST['Invoice']['surat_jalan'])
        ) {
            $soList = $_POST['Invoice']['surat_jalan'];
            $transaction = Yii::$app->db->beginTransaction();
            $isDetailSaved = true;
            try {
                $model->code = $this->generateInvoiceCode();
                $model->date = $model->date ." ".date('H:i:s');
                if ($model->save()) {
                    foreach ($soList as $soID) {
                        $invoiceDetail = new InvoiceDetail();
                        $invoiceDetail->invoice_id = $model->id;
                        $invoiceDetail->sales_id = $soID;
                        $so = Sales::findOne($soID);
                        if ($so) {
                            $so->invoiced = 1;
                            $so->save();
                        }
                        if (
                            $invoiceDetail->validate() && $invoiceDetail->save()
                        ) {
                            $isDetailSaved = $isDetailSaved && true;
                        }else {
                            $isDetailSaved = $isDetailSaved && false;
                        }
                    }
                    
                    if ($isDetailSaved) {
                        $transaction->commit();
                        return $this->redirect(['print-invoice', 'id' => $model->id]);
                    }else {
                        $transaction->rollback();
                    }
                }
            }catch (\Exception $e) {
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'vendorData' => $vendorList
            ]);
        }
    }

    /**
     * Letter to print
     */
    public function actionPrintInvoice($id)
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
     * function for generating invoice code
     */
    private function generateInvoiceCode()
    {
        $currMonth = date('n');
        $currYear = date('Y');
        $strWhere = "MONTH(date) = '$currMonth' AND YEAR(date) = '$currYear'";
        $invoice = Invoice::find()->where($strWhere)->orderBy('date DESC')->one();
        $prevIndex = 0;
        if ($invoice) {
            $prevIndex = (int) substr($invoice->code, 4, 3);    
        }
        $newIndex = $prevIndex + 1;
        $code = "INV/".str_pad($newIndex, 3, '0', STR_PAD_LEFT)."/".date('m')."/ETS/". date('Y');

        return $code;
    }

    /**
     * Get SO list based on vendor id
     */
    public function actionGetSjByVendor() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => []
        ];

        $soList = [];
        if (isset($_GET['vendor_id'])) {
            $vendorID = $_GET['vendor_id'];
            $so = Sales::find()->where([
                'vendor_id' => $vendorID,
                'invoiced' => false
            ])->orderBy('sales_date DESC')->all();
            foreach ($so as $item) {
                $soList[] = [
                    'id' => $item->id,
                    'code' => $item->code
                ];
            }

            $out['success'] = true;
            $out['data'] = $soList;
        }

        return $out;
    }

    /**
     * Updates an existing Invoice model.
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
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);
            $invDetail = InvoiceDetail::find()->where([
                'invoice_id' => $model->id
            ])->all();
            
            foreach ($invDetail as $item) {
                $so = Sales::findOne($item->sales_id);
                if ($so) {
                    $so->invoiced = 0;
                    $so->save();
                }
            }
            if ($model->delete()) {
                $transaction->commit();
            }
        } catch (\yii\db\IntegrityException  $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('error', "Data Tidak Dapat Dihapus Karena Dipakai Modul Lain");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
