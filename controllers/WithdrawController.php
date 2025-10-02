<?php

namespace app\controllers;

use app\models\Balance;
use app\models\FasyankesUser;
use app\models\Histkeu;
use Yii;
use app\models\Withdraw;
use app\models\WithdrawSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use zantknight\yii\gallery\models\Gallery4;
use zantknight\yii\gallery\models\GalleryOwner;

/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WithdrawController extends Controller
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
     * Lists all Withdraw models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Withdraw model.
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
     * Creates a new Withdraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Withdraw();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Withdraw model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->status == 'transferred') {
                $user = FasyankesUser::find()->where(['idfas' => $model->idfas])->one();
                $balance = Balance::find()->where(['idfas'=>$model->idfas])->one();
                if ($user && $balance) {
                    $user->saldo = $user->saldo - $model->amount;
                    $balance->initsaldo = $user->saldo;
                    if ($user->saldo >= 0) {
                        if ($user->save() && $model->save() && $balance->save()) {
                            Yii::$app->session->setFlash('success', "Transaksi penarikan telah berhasil dibuat!");
                            return $this->redirect(['index']);
                        }
                    }
                    Yii::$app->session->setFlash('error', "Saldo tidak boleh minus!");
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
                
            }else {
                Yii::$app->session->setFlash('error', "Silakan pilih satus menjadi transferred untuk memproses!");
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetImageAttachment($id) {
        $category = 'GALLERY4';
        $model = 'Withdraw';
        $galleryOwners = GalleryOwner::find()->where([
            'model' => $model, 
            'owner_id' => $id
        ])->all();
        $path = null;
        foreach ($galleryOwners as $go) {
            $gallery = Gallery4::findOne($go->gallery_id);
            if ($gallery->category == $category) {
                $path =  Yii::getAlias('@webroot')."/media/".$gallery->name.".".$gallery->ext;
            }    
        }
        if ($path != null && file_exists($path)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for internet explorer
            header("Content-Type: ".$gallery->type);
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($path));
            header("Content-Disposition: attachment; filename=".$gallery->name);
            return Yii::$app->response->sendFile($path, $gallery->name);
        }else {
            return null;
        }
    }

    /**
     * Deletes an existing Withdraw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        try {
            $model = $this->findModel($id);
            $currentTime = round(microtime(true) * 1000); 
            $userFas = FasyankesUser::findOne($model->idfas);
            if ($model->status == 'transferred') {
                $userFas->saldo = $userFas->saldo + $model->amount;
                $currentTime = round(microtime(true) * 1000); 
                $histKeu = new Histkeu();
                $histKeu->idkeu = (string)$currentTime;
                $histKeu->idfasyankes = $model->idfas;
                $histKeu->status = 'KREDIT';
                $histKeu->value = $model->amount;
                $histKeu->tglhist = Date('Y-m-d H:i:s');
                $histKeu->keterangan = 'Pembatalan transfer!';
                if ($histKeu->validate()) {
                    $histKeu->save();
                    $userFas->save();
                }
                
            }
            $model->status = 'canceled';
            $model->save();
             
        } catch(\yii\db\IntegrityException  $e) {
	        Yii::$app->session->setFlash('error', "Data Tidak Dapat Dihapus Karena Dipakai Modul Lain");
        } 
        return $this->redirect(['index']);
    }

    /**
     * Finds the Withdraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Withdraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Withdraw::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
