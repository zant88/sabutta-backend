<?php

namespace app\controllers;

use Yii;
use app\models\Driver;
use app\models\Apps;
use app\models\DriverSearch;
use app\models\Mrole;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DriverController implements the CRUD actions for Driver model.
 */
class DriverController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Driver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DriverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Driver model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Driver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Driver();
        $mrole = Mrole::find()->asArray()->all();

        if ($model->load(Yii::$app->request->post())) {
            $apps =  Apps::find()->where([
                'idapps' => 'idusr.peg' 
            ])->one();
            $prefix = '';
            $currValue = 0;
            if ($apps) {
                $prefix = $apps->desc;
                $currValue = $apps->value;
                $model->iddriver = $prefix.str_pad($currValue + 1, 3, "0", STR_PAD_LEFT);
                $model->telppersh = $model->telpdriver;
                $model->userid = $model->iddriver;
                $model->pass = md5('enviro');
                if ($model->validate()) {
                    $apps->value = (string) ($currValue + 1);
                    if ($apps->validate()  && $apps->save()) {
                        $model->save();
                        Yii::$app->session->setFlash('success', "Data telah berhasil disimpan!");
                        return $this->redirect(['index']);
                    }
                }
            }else {
                Yii::$app->session->setFlash('error', "Data gagal disimpan! Tidak ada konfigurasi apps");
                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'mrole' => $mrole,
            ]);
        }
    }

    /**
     * Updates an existing Driver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mrole = Mrole::find()->asArray()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data telah berhasil disimpan!");
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'mrole' => $mrole
            ]);
        }
    }

    /**
     * Deletes an existing Driver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
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
     * Finds the Driver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Driver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Driver::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
