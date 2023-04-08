<?php

namespace app\controllers;

use Yii;
use app\models\Jenissampah;
use app\models\JenissampahSearch;
use yii\web\Controller;
use app\models\Mrole;
use app\models\VendorWaste;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\MyController;

/**
 * JenissampahController implements the CRUD actions for Jenissampah model.
 */
class JenissampahController extends MyController
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
                        'actions' => ['index', 'view', 'get-vendor-waste', 'save-data', 'create', 'sampah-vendor', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Jenissampah models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JenissampahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jenissampah model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionGetVendorWaste($idsampah)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        $vendorWaste = VendorWaste::find()->where([
            'idsampah' => $idsampah
        ])->all();
        foreach ($vendorWaste as $vendor) {
            $out[] = [
                'vendor_id' => $vendor->vendor_id,
                'name' => $vendor->vendor->name,
                'price_kg' => $vendor->price_kg
            ];
        }
        return $out;
    }

    public function actionSaveData()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [
            'success' => false,
            'message' => 'No Valid Data'
        ];
        if (isset($_POST['idsampah']) && isset($_POST['items'])) {
            $arrData = json_decode($_POST['items']);
            foreach ($arrData as $item) {
                if (property_exists($item, 'id')) {
                    $model = VendorWaste::find()->where([
                        'vendor_id' => $item->id,
                        'idsampah' => $_POST['idsampah']
                    ])->one();
                    if (!$model) {
                        $model = new VendorWaste();
                    }
                    $model->idsampah = $_POST['idsampah'];
                    $model->vendor_id = $item->id;
                    $model->price_kg = $item->price;
                    $model->save();
                }

                $out['success'] = true;
                $out['message'] = 'Data Saved';
            }
        }

        return $out;
    }

    /**
     * Creates a new Jenissampah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jenissampah();
        $mrole = Mrole::find()->asArray()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->roleuser = Yii::$app->params['default_role'];
            $model->save();
            return $this->redirect(['view', 'id' => $model->idsampah]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'mrole' => $mrole
            ]);
        }
    }
    public function actionDataSampah()
    {
        echo 'hehe';
        die;
    }

    /**
     * Get waste based on vendor
     * 
     */
    public function actionSampahVendor($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        $model = VendorWaste::find()->where(['vendor_id' => $id])->all();
        foreach ($model as $item) {
            $out[] = [
                'id' => $item->idsampah,
                'price' => $item->price_kg,
                'waste_name' => $item->waste->nama
            ];
        }
        return $out;
        // return $this->redirect(['index']);
    }

    /**
     * Updates an existing Jenissampah model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mrole = Mrole::find()->asArray()->all();

        if ($model->load(Yii::$app->request->post())) {

            // keep this comment in case role put in update as well
            // if (isset($_POST['Jenissampah']['roleuser'])) {
            //     $strRole = '';
            //     foreach ($_POST['Jenissampah']['roleuser'] as $item) {
            //         if ($strRole == '') {
            //             $strRole = $strRole.$item;
            //         }else {
            //             $strRole = $strRole."#".$item;
            //         }
                    
            //     }
            // }
            // $model->roleuser = Yii::$app->params['default_role'];
            $model->save();
            return $this->redirect(['view', 'id' => $model->idsampah]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'mrole' => $mrole
            ]);
        }
    }

    /**
     * Deletes an existing Jenissampah model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        try {
            $model = $this->findModel($id);
            $model->status = "NON AKTIF";
            $model->save();
        } catch (\yii\db\IntegrityException  $e) {
            Yii::$app->session->setFlash('error', "Data Tidak Dapat Dihapus Karena Dipakai Modul Lain");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Jenissampah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Jenissampah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jenissampah::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
