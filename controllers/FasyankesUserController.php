<?php

namespace app\controllers;

use Yii;
use app\models\FasyankesUser;
use app\models\FasyankesUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\MyController;
use yii\db\Query;

/**
 * FasyankesUserController implements the CRUD actions for FasyankesUser model.
 */
class FasyankesUserController extends MyController
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
     * Lists all FasyankesUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FasyankesUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFasyankesList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('idfas as id, namafas AS text')
                ->from('mfasyankes')
                ->where(['like', 'namafas', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => FasyankesUser::find($id)->name];
        }
        return $out;
    }

    public function actionBankList($id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select(["idbank", "CONCAT(keterangan, ' - ', namabank) as text"], )
            ->from('mbank')
            ->where('idfas='.$id);
            // ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = array_values($data);
        return $out;
    }

    /**
     * Displays a single FasyankesUser model.
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
     * Creates a new FasyankesUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FasyankesUser();

        if ($model->load(Yii::$app->request->post())) {
            $model->pass = md5('enviro');
            if ($model->validate() && $model->save()) {
                
                if (isset($_POST['type']) && $_POST['type'] == 'is_add_new') {
                    Yii::$app->session->setFlash('success', "Data telah berhasil disimpan!");
                    return $this->redirect(['create']);
                }else {
                    Yii::$app->session->setFlash('success', "Data telah berhasil disimpan!");
                    return $this->redirect(['index']);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionResetPassword()
    {
        if (isset($_POST['id'])) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['success' => false];

            $model = FasyankesUser::findOne($_POST['id']);
            if ($model) {
                $model->pass = md5('enviro');
                $model->save();
                $out = ['success' => true];
                return $out;
            }
        } else {
            return $this->render('reset-password');
        }
    }

    /**
     * Updates an existing FasyankesUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idfas]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FasyankesUser model.
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
     * Finds the FasyankesUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FasyankesUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FasyankesUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
