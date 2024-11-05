<?php

namespace app\controllers;

use Yii;
use app\models\Stock;
use app\models\StockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Jenissampah;
use app\models\JenissampahSearch;
use app\components\MyController;

/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends MyController
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
            // 'access' => [
            //     'class' => \yii\filters\AccessControl::class,
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             'actions' => ['index', 'card', 'view', 'create', 'update', 'delete'],
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
        ];
    }

    /**
     * Lists all Stock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderExport = $searchModel->search(Yii::$app->request->queryParams);
        $weight = $searchModel->searchWeight(Yii::$app->request->queryParams);
        $balance = $searchModel->searchBalance(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderExport' => $dataProviderExport,
            'weight' => $weight,
            'balance' => $balance
        ]);
    }

    /**
     * Lists all Stock models.
     * @return mixed
     */
    public function actionCard()
    {
        // $searchModel = new StockSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('card', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

        $searchModel = new JenissampahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('card', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stock model.
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
     * Creates a new Stock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stock();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idstock]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Stock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idstock]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionSell() {
        return  $this->render('sale');
    }

    /**
     * Deletes an existing Stock model.
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
     * Finds the Stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
