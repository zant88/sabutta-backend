<?php

namespace app\controllers;

use app\models\Mbanksampah;
use app\models\Orderdetail;
use Yii;
use app\models\OrderRevision;
use app\models\OrderRevisionDetail;
use app\models\OrderRevisionSearch;
use app\modules\user\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderRevisionController implements the CRUD actions for OrderRevision model.
 */
class OrderRevisionController extends Controller
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
     * Lists all OrderRevision models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderRevisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderRevision model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $orderRevisionDetail = OrderRevisionDetail::find()->where([
            'order_revision_id' => $id
        ])->all();
        if (sizeof($orderRevisionDetail) > 0) {
            return $this->render('view', [
                'model' => $this->findModel($id),
                'order_revision' => $orderRevisionDetail
            ]);
        }else {
            return $this->redirect(['index']);
        }
        
    }

    /**
     * Creates a new OrderRevision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderRevision();

        if ($model->load(Yii::$app->request->post()) && isset($_POST['RevisionDetail'])) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $model->code = $this->generateRevisionCode();
                $model->revision_date = $model->revision_date." ".date('H:i:s');
                if (Yii::$app->user->can('admin')) {
                    $banksampah = Mbanksampah::findOne($_POST['OrderRevision']['banksampah_id']);
                    if ($banksampah) {
                        $model->banksampah_id =  $_POST['OrderRevision']['banksampah_id'];
                        $model->banksampah_code = $banksampah->banksampahid;
                    }
                }else {
                    $user = User::findOne(Yii::$app->user->id);
                    $model->banksampah_id =  $user->banksampah_id;
                    $model->banksampah_code = $user->banksampah_code;
                }
                $detRet = true;
                if ($model->save()) {
                    $postData = $_POST['RevisionDetail'];
                    foreach ($postData as $item) {
                        $modelDetail = new OrderRevisionDetail();
                        $modelDetail->order_revision_id = $model->id;
                        $modelDetail->sampah_id = $item['idsampah'];
                        $modelDetail->amount_diminished = $item['berat'];
                        $orderDetail = Orderdetail::find()->where([
                            'orderid' => $model->order_id,
                            'idsampah' => $item['idsampah']
                        ])->one();
                        if ($orderDetail) {
                            $unitPrice = $orderDetail->harga / $orderDetail->berat;
                            $orderDetail->berat = $orderDetail->berat - $item['berat'];
                            $orderDetail->harga = $unitPrice * $orderDetail->berat;
                            $orderDetail->save();
                        }
                        if ($modelDetail->save()) {
                            $detRet = $detRet && true;
                        }else {
                            $detRet = $detRet && false;
                        }
                    }
                    if ($detRet) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data telah berhasil disimpan!");
                        return $this->redirect(['index']);
                    }else {
                        $transaction->rollBack();
                    }
                }
            }catch (\Exception $e) {
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Generate code for sales code
     * 
     */
     private function generateRevisionCode() {
        $currDate = date('Y-m-d');
        $sales = OrderRevision::find()->where([
            'DATE(revision_date)' => $currDate
        ])->orderBy('revision_date DESC')->one();
        $prevIndex = 0;
        if ($sales) {
            $prevIndex = (int) substr($sales->code, 8);
        }
        $newIndex = $prevIndex + 1;
        $code = "RV" . date('dmy') . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        
        return $code;
    }

    /**
     * Updates an existing OrderRevision model.
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
     * Deletes an existing OrderRevision model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
       try
      {
        $this->findModel($id)->delete();
      
      }
      catch(\yii\db\IntegrityException  $e)
      {
	Yii::$app->session->setFlash('error', "Data Tidak Dapat Dihapus Karena Dipakai Modul Lain");
       } 
         return $this->redirect(['index']);
    }

    /**
     * Finds the OrderRevision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderRevision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderRevision::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
