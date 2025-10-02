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
use app\models\Mbanksampah;
use app\modules\user\models\User;

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
        $searchModel = new JenissampahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('card', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * stock opname process
     * @return mixed
     */
    public function actionStockOpname() {
        $waste = Jenissampah::find()->all();
        if (Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $postData = Yii::$app->request->post();
            $out = [
                'success' => false,
                'message' => 'Failed to save data!',
            ];
            if (
                array_key_exists('waste_id', $postData) &&
                array_key_exists('weight', $postData)
            ) {
                $stock = new Stock();
                $stock->idstock = (string) round(microtime(true) * 1000);
                $stock->idjnssampah = $postData['waste_id'];
                $user = User::findOne(Yii::$app->user->id);
                $bankSampah = Mbanksampah::findOne($user->banksampah_id);
                if ($postData['weight'] > 0) {
                    
                    $stock->jnsstock = 'IN';
                }else {
                    $stock->jnsstock = 'OUT'; // < 0 means stock out
                }
                $stock->nilai = abs($postData['weight']);
                $stock->tgl = date('Y-m-d');
                $stock->banksampah_id = $user->banksampah_id;
                $stock->banksampah_code = $bankSampah->banksampahid;
                if ($stock->validate()) {
                    $stock->save();
                    $out = [
                        'success' => true,
                        'message' => 'Successfully saving',
                    ];
                }
            }
            
            return $out;
        }
        return $this->render('stock-opname', [
            'waste' => $waste
        ]);
    }

    public function actionGetWasteBankStock($waste_id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $wasteBank = Mbanksampah::find()->all();
        $out = [];
        foreach ($wasteBank as $item) {
            $rowsIn = (new \yii\db\Query())
                ->select(['sum(nilai) as stockIn'])
                ->from('stock')
                ->where([
                    'jnsstock'=>'IN', 
                    'idjnssampah'=>$waste_id,
                    'banksampah_id'=>$item->id
                ])
                ->one();
            $rowsOut = (new \yii\db\Query())
                ->select(['sum(nilai) as stockOut'])
                ->from('stock')
                ->where([
                    'jnsstock'=>'OUT', 
                    'idjnssampah'=>$waste_id,
                    'banksampah_id'=>$item->id
                ])
                ->one();
            $amount = ($rowsIn['stockIn'] - $rowsOut['stockOut']);
            $out[] = [
                'bs_name' => $item->full_name,
                'qty' => $amount
            ];
        }

        return $out;
    }

    /**
     * get amount of stock based on particular waste
     * @return mixed
     */
    public function actionGetStock($waste_id) {
        $user = User::findOne(Yii::$app->user->id);
        $rowsIn = (new \yii\db\Query())
            ->select(['sum(nilai) as stockIn'])
            ->from('stock')
            ->where([
                'jnsstock'=>'IN', 
                'idjnssampah'=>$waste_id,
                'banksampah_id'=>$user->banksampah_id
            ])
            ->one();
        $rowsOut = (new \yii\db\Query())
            ->select(['sum(nilai) as stockOut'])
            ->from('stock')
            ->where([
                'jnsstock'=>'OUT', 
                'idjnssampah'=>$waste_id,
                'banksampah_id'=>$user->banksampah_id
            ])
            ->one();
        $amount = ($rowsIn['stockIn'] - $rowsOut['stockOut']);

        return $amount;
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
