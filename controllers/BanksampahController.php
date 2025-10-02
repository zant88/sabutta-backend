<?php

namespace app\controllers;

use Yii;
use app\models\Mbanksampah;
use app\models\MbanksampahSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\MyController;
use app\models\AppsProxy;
use app\modules\user\models\User;
use yii\db\Query;


/**
 * BanksampahController implements the CRUD actions for Mbanksampah model.
 */
class BanksampahController extends MyController
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
     * Lists all Mbanksampah models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MbanksampahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {
            $query = new Query;
            if (Yii::$app->user->can('admin')) {
                $query->select([
                    "CONCAT(CAST(id AS CHAR), ' - ', CAST(banksampahid AS CHAR)) AS id", 
                    "full_name AS text"
                ])->from('mbanksampah')
                    ->where(['like', 'full_name', $q])
                    ->limit(20);
                $command = $query->createCommand();
                $data = $command->queryAll();
                $out['results'] = array_values($data);
            }else {
                $user = User::findOne(Yii::$app->user->id);
                $query->select([
                    "CONCAT(CAST(id AS CHAR), ' - ', CAST(banksampahid AS CHAR)) AS id", 
                    "full_name AS text"
                ])
                ->from('mbanksampah')
                    ->where(['like', 'full_name', $q])
                    ->andWhere(['parent_id', $user->banksampah_id])
                    ->limit(20);
                $command = $query->createCommand();
                $data = $command->queryAll();
                $out['results'] = array_values($data);
            }
            
        }elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Mbanksampah::find($id)->full_name];
        }
        return $out;
    }

    /**
     * Displays a single Mbanksampah model.
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
     * Creates a new Mbanksampah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mbanksampah();

        if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $model->updated_at = $model->created_at;
            try {
                if ($model->validate() && $model->save()) {
                    $appProxy = new AppsProxy();
                    $appProxy->idapps = $model->banksampahid;
                    $appProxy->desk = "BS ".$model->full_name;
                    $appProxy->value = '{"baseUrl":"http://api-service:8090","logo":"http://103.150.196.160:7800/down/hTDufGS38Dav.png"}';
                    if ($appProxy->validate() && $appProxy->save()) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                }else {
                    echo '<pre>';
                    print_r($model->errors);
                    die;
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
     * Updates an existing Mbanksampah model.
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
     * Deletes an existing Mbanksampah model.
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
     * Finds the Mbanksampah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mbanksampah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mbanksampah::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
