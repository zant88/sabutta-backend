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
use yii\db\Query;

/**
 * SalesController implements the CRUD actions for Sales model.
 */
class SalesController extends Controller
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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

    public function actionSubmitSales()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // eg. SO00001
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
                $sales = Sales::find()->orderBy('sales_date DESC')->one();
                $prevIndex = 0;
                if ($sales) {
                    $prevIndex = (int) substr($sales->code, 2);
                }
                $newIndex = $prevIndex + 1;
                $code = "SO" . str_pad($newIndex, 5, '0', STR_PAD_LEFT);
                $sales = new Sales();
                $sales->vendor_id = $_POST['vendor_id'];
                $sales->code = $code;
                $sales->sales_date = $_POST['sales_date']. ' ' . date('H:i:s');
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
                            $salesDetail->save();
                            $stock = new Stock();
                            $stock->idstock = (string) round(microtime(true) * 1000);
                            $stock->idjnssampah = $item->id;
                            $stock->nilai = $item->weight;
                            $stock->jnsstock = 'OUT';
                            $stock->tgl = $_POST['sales_date'];
                            if ($stock->validate()) {
                                $stock->save();
                                $transaction->commit();
                                $out = [
                                    'success' => true,
                                ];
                            }
                        }
                    }
                }
                
            } catch (\Exception $e) {
                $transaction->rollback();
            }
        }

        return $out;
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
