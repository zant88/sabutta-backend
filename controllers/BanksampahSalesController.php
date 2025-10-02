<?php

namespace app\controllers;

use Yii;
use app\models\BanksampahSales;
use app\models\Sales;
use app\models\SalesDetail;
use app\models\Stock;
use app\models\BanksampahSalesDetail;
use app\models\BanksampahSalesSearch;
use app\models\Jenissampah;
use app\models\Mbanksampah;
use app\models\Vendor;
use app\models\VendorWaste;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\user\models\User;
use Exception;

/**
 * BanksampahSalesController implements the CRUD actions for BanksampahSales model.
 */
class BanksampahSalesController extends Controller
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
     * Lists all BanksampahSales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BanksampahSalesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BanksampahSales model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $vendorList = Vendor::find()->where([
            'status' => 1
        ])->all();
        $detail = BanksampahSalesDetail::find()->where([
            'banksampah_sales_id' => $id
        ])->all();
        $detailList = [];
        foreach ($detail as $item) {
            $sampah = Jenissampah::findOne($item->sampah_id);
            $detailList[] = [
                'id' => $item->id,
                'nama' => $sampah->nama,
                'quantity' => $item->quantity,
                'purchase_price' => $item->unit_price,
                'selling_price' => 0,
                'purchase_total' => $item->unit_price * $item->quantity,
                'selling_total' => 0
            ];
        }
        
        if (Yii::$app->user->can('admin')) {
            $sales = Sales::find()->where([
                'banksampah_sales_id' => $id
            ])->one();
            if ($sales) {
                if ($sales->surat_jalan_code) {
                    return $this->redirect(['sales/view', 
                        'id' => $sales->id
                    ]);
                }else {
                    return $this->redirect(['/sales/surat-jalan', 
                        'id' => $sales->id
                    ]);
                }
            }else {
                return $this->render('view', [
                    'model' => $this->findModel($id),
                    'detailList' => $detailList,
                    'vendorList' => $vendorList,
                ]);
            }
        }else {
            return $this->render('dispatching', [
                'model' => $this->findModel($id),
                'detailList' => $detailList,
                'vendorList' => $vendorList,
            ]);
            
        }
        
    }

    /**
     * Creates a new BanksampahSales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BanksampahSales();
        $sampahPrice = [];
        $isSaving = false;
        if (!Yii::$app->user->can('admin')) {
            $user = User::findOne(Yii::$app->user->id);
            $sampahList = Jenissampah::find()->where([
                'status' => 'AKTIF'
            ])->all();
            $bankSampah = Mbanksampah::findOne($user->banksampah_id);
            if ($bankSampah) {
                $isSaving = $bankSampah->is_saving == 1 ? true : false;
                // echo $isSaving;
                // die;
            }
            foreach ($sampahList as $item) {
                $detail = json_decode($item->json);
                // echo '<pre>';
                // print_r($detail);
                // die;
                try {
                    $priceConfigs = $detail->vendors;
                }catch (Exception $e) {
                    $priceConfigs = [];
                }
                // $priceConfigs = $detail->vendors;
                foreach ($priceConfigs as $itemPrice) {
                    if ($itemPrice->vendorId == $user->banksampah_code) {
                        $sampahPrice[] = [
                            'id' => $item->idsampah,
                            'name' => $item->nama,
                            'price' => $itemPrice->hargaJual,
                            'buying_price' => $itemPrice->hargaBeli
                        ];
                    }
                }
            }
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'sampahPrice' => $sampahPrice,
                'isSaving' => $isSaving
            ]);
        }
    }

    public function actionCalculate($id, $vendor_id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'status' => false,
            'data' => [],
            'message' => 'No sales id or vendor id are selected'
        ];
        $data = [];
        if ($id != null && $vendor_id != null) {
            $sales = BanksampahSales::findOne($id);
            if ($sales) {
                $salesDetail = BanksampahSalesDetail::find()->where([
                    'banksampah_sales_id' => $id
                ])->all();
                foreach ($salesDetail as $item){
                    $vendorWaste = VendorWaste::find()->where([
                        'vendor_id' => $vendor_id,
                        'idsampah' => $item->sampah_id
                    ])->one();
                    $sampah = Jenissampah::findOne($item->sampah_id);
                        
                    if ($vendorWaste) {
                        $purchaseTotal = $item->quantity * $item->unit_price;
                        $sellingTotal = $item->quantity * $vendorWaste->price_kg;
                        $data[] = [
                            'id' => $item->sampah_id,
                            'nama' => $sampah->nama,
                            'quantity' => $item->quantity,
                            'purchase_price' => $item->unit_price,
                            'selling_price' => $vendorWaste->price_kg,
                            'purchase_total' => $purchaseTotal,
                            'selling_total' => $sellingTotal,
                        ];
                    }else {
                        $purchaseTotal = $item->quantity * $item->unit_price;
                        $vendor = Vendor::findOne($vendor_id);
                        $sellingPrice = 0;
                        if ($vendor) {
                            $sellingPrice = $vendor->percentage_profit * $item->unit_price / 100 + $item->unit_price;
                        }
                        $sellingTotal = $sellingPrice * $item->quantity;
                        $data[] = [
                            'id' => $item->sampah_id,
                            'nama' => $sampah->nama,
                            'quantity' => $item->quantity,
                            'purchase_price' => $item->unit_price,
                            'selling_price' => $sellingPrice,
                            'purchase_total' => $purchaseTotal,
                            'selling_total' => $sellingTotal,
                        ];
                    }
                }
                $out = [
                    'status' => true,
                    'data' => $data,
                    'message' => 'Data found!'
                ];
            }
        }
        return $out;
    }

    public function actionGetStock($id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::findOne(Yii::$app->user->id);
        $rowsIn = (new \yii\db\Query())
            ->select(['sum(nilai) as stockIn'])
            ->from('stock')
            ->where([
                'jnsstock'=>'IN', 
                'idjnssampah'=>$id,
                'banksampah_id'=>$user->banksampah_id
            ])
            ->one();
        $rowsOut = (new \yii\db\Query())
            ->select(['sum(nilai) as stockOut'])
            ->from('stock')
            ->where([
                'jnsstock'=>'OUT', 
                'idjnssampah'=>$id,
                'banksampah_id'=>$user->banksampah_id
            ])
            ->one();
        $amount = ($rowsIn['stockIn'] - $rowsOut['stockOut']);
        return $amount;
    }

    public function actionDispatchWaste() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
        ];

        if (
            isset($_POST['id']) 
        ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $salesDetail = SalesDetail::find()->where([
                    'sales_id' => $_POST['id']
                ])->all();
                $sales = Sales::findOne($_POST['id']);
                $bankSampahId = null;
                $bankSampahCode = null;
                if ($sales) {
                    $sales->status = "DONE";
                    $bankSampahSales = BanksampahSales::findOne($sales->banksampah_sales_id);
                    if ($bankSampahSales) {
                        $bankSampahSales->status = "DONE";
                        $bankSampahSales->save();
                    }
                    $bankSampah = Mbanksampah::findOne($sales->banksampah_id);
                    if ($bankSampah && $sales->save()) {
                        $bankSampahId = $bankSampah->id;
                        $bankSampahCode = $bankSampah->banksampahid;
                    }
                }
                $isSaved = true;
                foreach($salesDetail as $item) {
                    $stock = new Stock();
                    $stock->idstock = (string) round(microtime(true) * 1000);
                    $stock->idjnssampah = $item->sampah_id;
                    $stock->nilai = $item->amount_kg;
                    $stock->jnsstock = 'OUT';
                    $stock->tgl = date('Y-m-d');
                    $stock->created_at = date('Y-m-d H:i:s');
                    $stock->banksampah_id = $bankSampahId;
                    $stock->banksampah_code = $bankSampahCode;
                    if ($stock->validate() && $stock->save()) {
                        $isSaved = $isSaved & true;
                    }else {
                        $isSaved = $isSaved & false;
                    }
                }
                if ($isSaved) {
                    $transaction->commit();
                    $out['success'] = true;
                }else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollback();
            }
        }

        return $out;
    }

    /**
     * Updates an existing BanksampahSales model.
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
     * Deletes an existing BanksampahSales model.
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
     * Finds the BanksampahSales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BanksampahSales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BanksampahSales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSubmit()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // eg. SO00001 SO1104220001
        $out = [
            'success' => false,
        ];

        if (
            isset($_POST['sales_date']) &&
            isset($_POST['total']) &&
            isset($_POST['items'])
        ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $sales = new BanksampahSales();
                $sales->code = $this->generateSalesCode();
                $sales->transaction_date = $_POST['sales_date'] . ' ' . date('H:i:s');
                $sales->status = "OPEN";
                $sales->total = $_POST['total'];
                $user = User::findOne(Yii::$app->user->id);
                if ($user) {
                    $sales->from_banksampah_id = $user->banksampah_id;
                }
                $detailSaved = true;
                $processedTransaction = true;
                if ($sales->validate() && $sales->save()) {
                    $data = json_decode($_POST['items']);
                    // $data = json_decode($_POST['items']);
                    $listWaste = [];
                    foreach ($data as $itemWaste) {
                        $listWaste[] = [
                            'idwaste' => $itemWaste->id,
                            'currentPrice' => $itemWaste->hargaBeli,
                            'priceAdjustment' => $itemWaste->harga,
                        ];
                    }
                    foreach ($data as $item) {
                        $salesDetail = new BanksampahSalesDetail();
                        $salesDetail->banksampah_sales_id = $sales->id;
                        $salesDetail->sampah_id = $item->id;
                        $salesDetail->quantity = $item->weight;
                        $salesDetail->unit_price = $item->harga;
                        $salesDetail->amount = $item->weight * $item->harga;
                        if ($salesDetail->validate()) {
                            if ($salesDetail->save()) {
                                $detailSaved = $detailSaved && true;
                            }else {
                                $detailSaved = $detailSaved && false;
                            }
                        }
                    }
                    $data = [
                        'userId' => Yii::$app->user->id,
                        'salesCode' => $sales->code,
                        'listWaste' => $listWaste
                    ];
                    if ($detailSaved) {
                        $transaction->commit();
                        // $processedTransaction = $this->processTransaction('https://api.sabutta.co.id/trxadjustment', $data);
                    
                    }
                    // echo $processedTransaction;
                    // die;
                    if ($processedTransaction && $detailSaved) {
                        $out = [
                            'success' => true,
                            'message' => 'Data has been saved!'
                        ];
                    }
                }else {
                    $out['message'] = $sales->errors;
                    $transaction->rollback();
                }
            } catch (\Exception $e) {
                $out['message'] = $e->getMessage();
                $transaction->rollback();
            }
        }

        return $out;
    }

    public function actionSubmit2()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // eg. SO00001 SO1104220001
        $out = [
            'success' => false,
        ];

        if (
            isset($_POST['id']) &&
            isset($_POST['vendor_id']) &&
            isset($_POST['phone'])
        ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $bankSampahSales = BanksampahSales::findOne($_POST['id']);
                $vendor = Vendor::findOne($_POST['vendor_id']);
                $saved = true;
                if ($bankSampahSales && $vendor) {
                    $sales = new Sales();
                    $sales->vendor_id = $_POST['vendor_id'];
                    $sales->code = $this->generateBanksampahSalesCode();
                    $sales->sales_date = date('Y-m-d H:i:s');
                    $sales->total = $bankSampahSales->total;
                    $sales->status = 'SELLING_PROCESS';
                    if ($sales->validate() && $sales->save()) {
                        $vendor->phone = $_POST['phone'];
                        $vendor->save();
                        
                        $details = BanksampahSalesDetail::find()->where([
                            'banksampah_sales_id' => $_POST['id']
                        ])->all();
                        if (sizeof($details) > 0) {
                            foreach ($details as $item) {
                                $vendorWaste = VendorWaste::find()->where([
                                    'vendor_id' => $vendor->id,
                                    'idsampah' => $item->sampah_id
                                ])->one();
                                $sellingPrice = 0;
                                if ($vendorWaste) {
                                    $sellingPrice = $vendorWaste->price_kg; 
                                }else {
                                    $sellingPrice = ($vendor->percentage_profit * $item->unit_price) + $item->unit_price;
                                }
                                $salesDetail = new SalesDetail();
                                $salesDetail->sales_id = $sales->id;
                                $salesDetail->sampah_id = $item->sampah_id;
                                $salesDetail->amount_kg = $item->quantity;
                                $salesDetail->total_price = $item->quantity * $sellingPrice;
                                if ($salesDetail->validate()) {
                                    if ($salesDetail->validate() && $salesDetail->save()) {
                                        $saved = $saved && true;
                                        // Do this on delivery process
                                        // $stock = new Stock();
                                        // $stock->idstock = (string) round(microtime(true) * 1000);
                                        // $stock->idjnssampah = $item->id;
                                        // $stock->nilai = $item->weight;
                                        // $stock->jnsstock = 'OUT';
                                        // $stock->tgl = $_POST['sales_date'];
                                        // if ($stock->validate()) {
                                        //     $stock->save();
                                        //     $out = [
                                        //         'success' => true,
                                        //         'id' => $sales->id,
                                        //     ];
                                        // }
                                    }else {
                                        $saved = $saved && false;
                                        echo '<pre>';
                                        print_r($salesDetail->errors);
                                        break;
                                        die;
                                    }
                                }else {
                                    echo "<pre>";
                                    print_r($salesDetail);
                                    die;
                                }
                            }
                        }
                        if ($saved) {
                            $out = [
                                'success' => true,
                            ];
                            $transaction->commit(); 
                        }    
                    }else {
                        echo '<pre>';
                        print_r($sales->errors);
                        die;
                    }
                }
                
            } catch (\Exception $e) {
                $out['message'] = $e->getMessage();
                $transaction->rollback();
            }
        }

        return $out;
    }

    public function actionSellToVendor()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // eg. SO00001 SO1104220001
        $out = [
            'success' => false,
        ];

        if (
            isset($_POST['id']) &&
            isset($_POST['vendor_id']) &&
            isset($_POST['phone'])
        ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $bankSampahSales = BanksampahSales::findOne($_POST['id']);
                $vendor = Vendor::findOne($_POST['vendor_id']);
                $saved = true;
                if ($bankSampahSales && $vendor) {
                    $sales = new Sales();
                    $sales->vendor_id = $_POST['vendor_id'];
                    $sales->code = $this->generateBanksampahSalesCode();
                    $sales->sales_date = date('Y-m-d H:i:s');
                    $sales->total = $bankSampahSales->total;
                    $sales->status = 'SELLING_PROCESS';
                    $sales->banksampah_sales_id = $bankSampahSales->id;
                    $sales->banksampah_id = $bankSampahSales->from_banksampah_id;
                    if ($sales->validate() && $sales->save()) {
                        $vendor->phone = $_POST['phone'];
                        $vendor->save();
                        $details = BanksampahSalesDetail::find()->where([
                            'banksampah_sales_id' => $_POST['id']
                        ])->all();
                        if (sizeof($details) > 0) {
                            foreach ($details as $item) {
                                $vendorWaste = VendorWaste::find()->where([
                                    'vendor_id' => $vendor->id,
                                    'idsampah' => $item->sampah_id
                                ])->one();
                                $sellingPrice = 0;
                                if ($vendorWaste) {
                                    $sellingPrice = $vendorWaste->price_kg; 
                                }else {
                                    $sellingPrice = ($vendor->percentage_profit * $item->unit_price) + $item->unit_price;
                                }
                                $salesDetail = new SalesDetail();
                                $salesDetail->sales_id = $sales->id;
                                $salesDetail->sampah_id = $item->sampah_id;
                                $salesDetail->amount_kg = $item->quantity;
                                $salesDetail->total_price = $item->quantity * $sellingPrice;
                                if ($salesDetail->validate()) {
                                    if ($salesDetail->save()) {
                                        $saved = $saved && true;
                                        // Do this on delivery process
                                        // $stock = new Stock();
                                        // $stock->idstock = (string) round(microtime(true) * 1000);
                                        // $stock->idjnssampah = $item->id;
                                        // $stock->nilai = $item->weight;
                                        // $stock->jnsstock = 'OUT';
                                        // $stock->tgl = $_POST['sales_date'];
                                        // if ($stock->validate()) {
                                        //     $stock->save();
                                        //     $out = [
                                        //         'success' => true,
                                        //         'id' => $sales->id,
                                        //     ];
                                        // }
                                    }else {
                                        $saved = $saved && false;
                                    }
                                }
                            }
                        }
                        if ($saved) {
                            $out = [
                                'success' => true,
                                'message' => 'Data has been saved!'
                            ];
                            $transaction->commit(); 
                        }    
                    }
                }
                
            } catch (\Exception $e) {
                $out = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
                $transaction->rollback();
            }
        }

        return $out;
    }

    private function generateBanksampahSalesCode() {
        $currDate = date('Y-m-d');
        $sales = BanksampahSales::find()->where([
            'DATE(transaction_date)' => $currDate
        ])->orderBy('id DESC')->one();
        $prevIndex = 0;
        if ($sales) {
            $prevIndex = (int) substr($sales->code, 8);
        }
        $newIndex = $prevIndex + 1;
        $code = "BS" . date('dmy') . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        
        return $code;
    }

    private function generateSalesCode() {
        $currDate = date('Y-m-d');
        $sales = BanksampahSales::find()->where([
            'DATE(transaction_date)' => $currDate
        ])->orderBy('transaction_date DESC')->one();
        $prevIndex = 0;
        if ($sales) {
            $prevIndex = (int) substr($sales->code, 8);
        }
        $newIndex = $prevIndex + 1;
        $code = "BS" . date('dmy') . str_pad($newIndex, 4, '0', STR_PAD_LEFT);
        
        return $code;
    }

    private function processTransaction($url, $data) {
        // The URL of the external endpoint
        // $url = 'https://example.com/api/submit';

        // Data to be sent in the POST request
        // $data = [
        //     'name' => 'John Doe',
        //     'email' => 'john.doe@example.com',
        //     'message' => 'Hello, this is a test message.'
        // ];
        // print_r($data);
        // die;
        
        $ret = false;
        // Initialize cURL
        $ch = curl_init($url);
        $jsonData = json_encode($data);

        // Set the options for the cURL request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_POST, true); // Set the request method to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Set the POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        // Execute the cURL request and store the response
        $response = curl_exec($ch);
        // Check for cURL errors
        if (curl_errno($ch)) {
            // echo 'cURL error: ' . curl_error($ch);
            $ret = false;
        } else {
            // Check the HTTP status code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode == 200) {
                $ret = true;
                // echo 'Success! Response: ' . $response;
                // die;
            } else {
                $ret = false;
                // echo 'HTTP error: ' . $httpCode . ' Response: ' . $response;
                // die;
            }
        }

        // Close the cURL session
        curl_close($ch);

        return $ret;
    }
}
