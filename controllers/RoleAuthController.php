<?php

namespace app\controllers;

use app\models\AuthMaster;
use Yii;
use app\models\RoleAuth;
use app\models\RoleAuthSearch;
use app\modules\user\models\Role;
use stdClass;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\MyController;
/**
 * RoleAuthController implements the CRUD actions for RoleAuth model.
 */
class RoleAuthController extends MyController
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
     * Lists all RoleAuth models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleAuthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RoleAuth model.
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
     * Creates a new RoleAuth model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RoleAuth();
        $role = Role::find()->all();
        $module = AuthMaster::find()->select('module')->distinct()
            ->where('module IS NOT NULL')->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'role' => $role,
                'module' => $module
            ]);
        }
    }

    public function actionSaveController() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $ret = [
            'success' => false
        ];
        if (
            isset($_POST['auth_master_selected']) && 
            isset($_POST['role_id']) && 
            isset($_POST['_csrf'])
        ) {
            $authMasterSelected = json_decode($_POST['auth_master_selected']);
            $roleID = $_POST['role_id'];
            foreach ($authMasterSelected as $itemStd) {
                $item = (array) $itemStd;
                $roleAuth = RoleAuth::find()->where([
                    'role_id' => $roleID,
                    'auth_id' => $item['id']
                ])->one();
                if (!$roleAuth) {
                    $roleAuth = new RoleAuth();
                    $roleAuth->role_id = $roleID;
                    $roleAuth->auth_id = $item['id'];
                    if ($roleAuth->save()) {
                        $ret = [
                            'success' => true
                        ];
                    }
                }
            }
        }
        
        return $ret;
    }

    public function actionDeleteItem() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $ret = false;
        
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $model = RoleAuth::findOne($id);
            if ($model) {
                if ($model->delete()) {
                    $ret = true;
                }
            }
        }

        return $ret;
    }

    public function actionGetList($module, $role=null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $ret = [];
        if ($module == -1) {
            if ($role != null) {
                $arrID = RoleAuth::find()->select('auth_id')->where([
                    'role_id' => $role
                ])->asArray()->all();
                $authMaster = AuthMaster::find()
                    ->where('module IS NULL')
                    ->andWhere([
                        'NOT IN', 'id', $arrID
                    ])->asArray()->all();
                $ret = $authMaster;
            }else {
                $authMaster = AuthMaster::find()
                    ->where('module IS NULL')->asArray()->all();
                $ret = $authMaster;
            }
            
        }else {
            if ($role != null) {
                $roleAuth = RoleAuth::find()->where([
                    'role_id' => $role
                ])->all();
                $arrID = [];
                foreach ($roleAuth as $item) {
                    $arrID[] = $item->id;
                }
                
                $authMaster = AuthMaster::find()
                    ->where(['module' => $module])
                    ->andWhere([
                        'NOT IN', 'id', $arrID
                    ])->asArray()->all();
                $ret = $authMaster;
            }else {
                $authMaster = AuthMaster::find()
                    ->where(['module' => $module])
                    ->asArray()->all();
                $ret = $authMaster;
            }
        }

        return $ret;
    }

    public function actionGetCurrentList($role) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $ret = [];
        if ($role != '') {
            $roleAuth = RoleAuth::find()->joinWith(['auth'])->where([
                'role_id' => $role
            ])->all();

            foreach ($roleAuth as $item) {
                $ret[] = [
                    'id' => $item->id,
                    'role_id' => $item->role_id,
                    'name' => $item->auth->name,
                    'controller' => $item->auth->module,
                    'controller' => $item->auth->controller,
                    'action' => $item->auth->action
                ];
            }
        }

        return $ret;
    }

    /**
     * Updates an existing RoleAuth model.
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
     * Deletes an existing RoleAuth model.
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
     * Finds the RoleAuth model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RoleAuth the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RoleAuth::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
