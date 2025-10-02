<?php

namespace app\controllers;

use Yii;
use app\models\Jenissampah;
use app\models\JenissampahSearch;
use yii\web\Controller;
use app\models\Mrole;
use app\models\VendorWaste;
use app\models\ProdukUser;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\MyController;
use app\models\Mbanksampah;
use app\modules\user\models\User;
use stdClass;
use yii\db\Query;

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

    public function actionWasteList() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $query = new Query;
        $query->select(["idsampah", "nama"], )
            ->from('jenissampah');
            // ->where("idorder LIKE '%".$q."%'");
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
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
        $hargaDiterima = 0;
        $user = User::findOne(Yii::$app->user->id);
        $userBSCode = ''; 
        if (!Yii::$app->user->can('admin')) {
            $userBSCode = $user->banksampah_code;
            if (!$userBSCode) {
                $bankSampah = Mbanksampah::findOne($user->banksampah_id);
                $userBSCode = $bankSampah->banksampahid;
            }
        }
        if ($model->json) {
            $data = json_decode($model->json);        
            $dataArray = json_decode(json_encode($data), true);
            $dataArray = $dataArray['vendors'];
            
            foreach ($dataArray as $itemSampah) {
                
                if ($userBSCode == $itemSampah['vendorId']) {
                    if (!Yii::$app->request->isPost) {
                        $model->hargaBS = array_key_exists('hargaBeli', $itemSampah) ? $itemSampah['hargaBeli'] : 0;
                    }
                    $hargaDiterima = $itemSampah['hargaJual'];
                }
            }
        }
        $mrole = Mrole::find()->asArray()->all();
        $productUser = ProdukUser::find()->where(['idsampah' => $id])->all();
        if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $detRet = true;
                if (isset($_POST['PriceDetail'])) {
                    $postData = $_POST['PriceDetail'];
                    $data = json_decode($model->json);
                    
                    $dataArray = json_decode(json_encode($data), true);
                    $dataArray = $dataArray['vendors'];
                    foreach ($postData as $itemPost) {
                        $isNew = true;
                        foreach ($data->vendors as $i => $item) {
                            if ($itemPost['id'] == $item->vendorId) {
                                $isNew = false;
                                $bankSampah = Mbanksampah::findOne($itemPost['id']);
                                $parentId = null;
                                if ($bankSampah) {
                                    $parentId = $bankSampah->parent_id;
                                }   
                                $isNew = false;
                                $dataArray[$i]['vendorName'] = $itemPost['banksampah_name'];
                                $dataArray[$i]['parentId'] = $parentId;
                                // $dataArray[$i]['hargaBeli'] = $itemPost['price'];
                                $dataArray[$i]['hargaJual'] = $itemPost['priceSold'];
                            }
                        }
                        if ($isNew) {
                            $obj = new stdClass();
                            $parentId = null;
                            $bankSampah = Mbanksampah::findOne($itemPost['id']);
                            if ($bankSampah) {
                                $parentId = $bankSampah->parent_id;
                            }
                            $obj->vendorId = $itemPost['id'];
                            $obj->vendorName = $itemPost['banksampah_name'];
                            $obj->parentId = $parentId;
                            // $obj->hargaBeli = $itemPost['price'];
                            $obj->hargaJual = $itemPost['priceSold'];
                            $data->vendors[] = $obj;
                            $dataArray[sizeof($postData)]['vendorId'] =  $itemPost['id'];
                            $dataArray[sizeof($postData)]['vendorName'] = $itemPost['banksampah_name'];
                            $dataArray[sizeof($postData)]['parentId'] = $parentId;
                            // $dataArray[sizeof($postData)]['hargaBeli'] = $itemPost['price'];
                            $dataArray[sizeof($postData)]['hargaJual'] = $itemPost['priceSold'];
                        }
                    }
                    $model->json = json_encode([
                        'vendors' => $dataArray
                    ]);
                }

                if (!Yii::$app->user->can('admin')) {
                    
                    $detRet = true;
                    $isNew = true;
                    if ($model->json) {
                        $data = json_decode($model->json);        
                        $dataArray = json_decode(json_encode($data), true);
                        $dataArray = $dataArray['vendors'];
                        $user = User::findOne(Yii::$app->user->id); 
                        foreach ($dataArray as $j => $itemSampah) {
                            if ($userBSCode == $itemSampah['vendorId']) {
                                $isNew = false;
                                $bankSampah = Mbanksampah::find()->where([
                                    'banksampahid' => $userBSCode
                                ])->one();
                                $vendorName = "";
                                if ($bankSampah) {
                                    $vendorName = $bankSampah->full_name;
                                }
                                $isNew = false;
                                $dataArray[$j]['vendorName'] = $vendorName;
                                $dataArray[$j]['hargaBeli'] = $_POST['Jenissampah']['hargaBS'];
                                $dataArray[$j]['hargaJual'] = $itemSampah['hargaJual'];
                            }
                        }
                        if ($isNew) {
                            $n = sizeof($dataArray);
                            $obj = new stdClass();
                            $parentId = null;
                            $bankSampah = Mbanksampah::find()->where([
                                'banksampahid' => $userBSCode
                            ])->one();
                            if ($bankSampah) {
                                $parentId = $bankSampah->parent_id;
                            }
                            $dataArray[$n]['vendorName'] = $bankSampah->full_name;
                            $dataArray[$n]['vendorId'] = $bankSampah->banksampahid;
                            $dataArray[$n]['hargaBeli'] = $_POST['Jenissampah']['hargaBS'];
                            $dataArray[$n]['hargaJual'] = $_POST['Jenissampah']['hargaBS'];
                        }

                        $model->json = json_encode([
                            'vendors' => $dataArray
                        ]);
                    }
                }
                if ($detRet) {
                    if ($model->validate() && $model->save() ) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', "Data telah berhasil disimpan!");
                        return $this->redirect(['index']);
                    }else {
                        echo '<pre>';
                        print_r($model->errors);
                        die;
                    }
                    
                }else {
                    $transaction->rollBack();
                }
            }catch (\Exception $e) {
                echo '<pre>';
                print_r($e->getMessage());
                die;
                $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'mrole' => $mrole,
                'produkUser' => $productUser,
                'hargaDiterima' => $hargaDiterima
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
