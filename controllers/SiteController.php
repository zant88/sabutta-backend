<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\MyController;
use app\modules\user\models\User;

class SiteController extends MyController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction( $action ) {
        if ( parent::beforeAction ( $action ) ) {
             //change layout for error action after 
             //checking for the error action name 
             //so that the layout is set for errors only
            if ( $action->id == 'error' ) {
                $this->layout = 'exception';
            }
            return true;
        } 
    }

    /**
     * get Total User
     */
    public function actionGetTotalUser() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];

        $query = (new \yii\db\Query())->from('mfasyankes')->where("role='0101#BS-USER'");
        $totalBSUser = $query->count('*');
        $out = [
            'success' => true,
            'data' => $totalBSUser
        ];

        return $out;
    }

    /**
     * get Total User
     */
    public function actionGetTotalSales() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $date = date('Y-m-d');
        $query = (new \yii\db\Query())->from('sales')
            ->where("DATE(sales_date)='$date'");
        $totalSales = $query->sum('total');
        if (!$totalSales) {
            $totalSales = 0;
        }
        $out = [
            'success' => true,
            'data' => $totalSales
        ];

        return $out;
    }

    /**
     * get Today Weight
     */
    public function actionGetTodayWeight() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $date = date('Y-m-d');
        if (Yii::$app->user->can('admin')) {
            $query = (new \yii\db\Query())->from('order')
                ->where("DATE(tanggalinput)='$date'");
            $weightTotal = $query->sum('berat');
            if (!$weightTotal) {
                $weightTotal = 0;
            }
            $out = [
                'success' => true,
                'data' => $weightTotal
            ];
        }else {
            $user  = User::findOne(Yii::$app->user->id);
            $query = (new \yii\db\Query())->from('order')
                ->where("DATE(tanggalinput)='$date' AND banksampah_id=".$user->banksampah_id);
            $weightTotal = $query->sum('berat');
            if (!$weightTotal) {
                $weightTotal = 0;
            }
            $out = [
                'success' => true,
                'data' => $weightTotal
            ];
        }
        

        return $out;
    }

    /**
     * get Today Item Amount
     */
    public function actionGetTodayAmount() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $date = date('Y-m-d');
        if (Yii::$app->user->can('admin')) {
            $query = (new \yii\db\Query())->from('orderdetail')
                ->leftJoin('order', 'orderid=idorder')
                ->where("DATE(tanggalinput)='$date'");
            $itemTotal = $query->count('DISTINCT idsampah');
        } else {
            $user  = User::findOne(Yii::$app->user->id);
            $query = (new \yii\db\Query())->from('orderdetail')
                ->leftJoin('order', 'orderid=idorder')
                ->where("DATE(tanggalinput)='$date' AND banksampah_id=".$user->banksampah_id);
            $itemTotal = $query->count('DISTINCT idsampah');
        }
        
        if (!$itemTotal) {
            $itemTotal = 0;
        }
        $out = [
            'success' => true,
            'data' => $itemTotal
        ];

        return $out;
    }

    /**
     * get Today Item Amount
     */
    public function actionGetMaxWasteMonthly() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $date = date('Y-m-d');
        // if (Yii::$app->user->can('admin')) {
            
        //     $query = (new \yii\db\Query())->from('orderdetail od')
        //         ->leftJoin('order o', 'orderid=idorder')
        //         ->leftJoin('jenissampah js', 'od.idsampah=js.idsampah')
        //         ->where("MONTH(tanggalinput)='$month' AND YEAR(tanggalinput)='$year'")
        //         ->orderBy('od.berat DESC');
        // } else {
        //     $user  = User::findOne(Yii::$app->user->id);
        //     $query = (new \yii\db\Query())->from('orderdetail')
        //         ->leftJoin('order', 'orderid=idorder')
        //         ->where("DATE(tanggalinput)='$date' AND banksampah_id=".$user->banksampah_id);
        //     $itemTotal = $query->count('DISTINCT idsampah');
        // }
        $year = date('Y');
        $month = date('n');

        if (Yii::$app->user->can('admin')) {
            $strWhere = "MONTH(tanggalinput)='$month' AND YEAR(tanggalinput)='$year'";
        }else {
            $user = User::findOne(Yii::$app->user->id);
            $strWhere = "MONTH(tanggalinput)='$month' AND YEAR(tanggalinput)='$year' AND banksampah_id=".$user->banksampah_id;
        }

        $query = (new \yii\db\Query())
                ->select('DISTINCT(js.idsampah) as idsampah, js.nama')
                ->from('orderdetail od')
                ->leftJoin('order o', 'orderid=idorder')
                ->leftJoin('jenissampah js', 'od.idsampah=js.idsampah')
                ->where($strWhere)
                ->orderBy('od.berat DESC')
                ->limit(10)
                ->all();
        $data = [];
        foreach ($query as $item) {
            $strW = $strWhere." AND idsampah='".$item['idsampah']."'";
            $queryItem = (new \yii\db\Query())->from('orderdetail od')
                ->leftJoin('order o', 'orderid=idorder')
                ->where($strW);

            $weightTotal = $queryItem->sum('od.berat');
            $data[] = [
                'idsampah' => $item['idsampah'],
                'nama' => $item['nama'],
                'total' => $weightTotal,
            ];
        }
        
        $out = [
            'success' => true,
            'data' => $data
        ];

        return $out;
    }

    private function countObjectLength($arrObj) {
        $ret = 0;
        foreach ($arrObj as $key => &$value) {
            $ret = strlen($key);
        }
        
        return $ret;
    }

    /**
     * get Today Transaction Fee
     */
    public function actionGetTodayTransactionFee() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $todayTrxFee = 0;
        $date = date('Y-m-d');
        $query = (new \yii\db\Query())->from('apps')
            ->where("idapps='trx.fee'")->one();
        if ($this->countObjectLength($query) > 0) {
            $query2 = (new \yii\db\Query())->from('order')
                ->where("DATE(tanggalinput)='$date'");
            $weightTotal = $query2->sum('berat');
            if (!$weightTotal) {
                $weightTotal = 0;
            }
            $todayTrxFee = $weightTotal * $query['value'];

            $out = [
                'success' => true,
                'data' => $todayTrxFee
            ];
        }
        
        return $out;
    }

    public function actionGetChartWeekly() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $dates = [];
        for ($i=1;$i<=7; $i++) {
            $date = date('Y-m-d', strtotime("-$i days"));
            
            if (Yii::$app->user->can('admin')) {
                $strWhere = "DATE(tanggalinput) = '".$date."'";
            }else {
                $user = User::findOne(Yii::$app->user->id);
                $strWhere = "DATE(tanggalinput) = '".$date."' AND banksampah_id=".$user->banksampah_id;
            }
            $query = (new \yii\db\Query())->from('orderdetail od')
                ->leftJoin('order o', 'orderid=idorder')
                ->where($strWhere);

            $weightTotal = $query->sum('od.berat');
            if (!$weightTotal) {
                $weightTotal = 0;
            }
            $dates[] = [
                'date' => $date,
                'day' => date('D', strtotime($date))." ".date('j/m', strtotime($date)),
                'weight' => $weightTotal
            ];
        }
        $out = [
            'success' => true,
            'data' => $dates
        ];

        return $out;
    }

    public function actionGetChartTodayWeight() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        if (Yii::$app->user->can('admin')) {
            $date = date('Y-m-d', strtotime("-1 days"));
            $strWhere = "tanggalinput = '".$date."'";
        }else {
            $user = User::findOne(Yii::$app->user->id);
            $date = date('Y-m-d', strtotime("-1 days"));
            $strWhere = "tanggalinput = '".$date."' AND banksampah_id=".$user->banksampah_id;
        }
        $query = (new \yii\db\Query())->from('order')
            ->where($strWhere);
        $weightYesterday = $query->sum('berat');
        if (!$weightYesterday) {
            $weightYesterday = 0;
        }

        if (Yii::$app->user->can('admin')) {
            $date = date('Y-m-d');
            $strWhere = "tanggalinput = '".$date."'";
        }else {
            $user = User::findOne(Yii::$app->user->id);
            $date = date('Y-m-d');
            $strWhere = "tanggalinput = '".$date."' AND banksampah_id=".$user->banksampah_id;
        }
        $query = (new \yii\db\Query())->from('order')
            ->where($strWhere);
        $weightToday = $query->sum('berat');
        if (!$weightToday) {
            $weightToday = 0;
        }
        $out = [
            'success' => true,
            'data' => [
                'today_weight' => $weightToday,
                'yesterday_weight' => $weightYesterday,
            ]
        ];

        return $out;
    }

    /**
     * get This month Transaction Fee
     */
    public function actionGetThisMonthTransactionFee() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $todayTrxFee = 0;
        $month = date('n');
        $query = (new \yii\db\Query())->from('apps')
            ->where("idapps='trx.fee'")->one();
        if ($this->countObjectLength($query) > 0) {
            $query2 = (new \yii\db\Query())->from('order')
                ->where("MONTH(tanggalinput)='$month'");
            $weightTotal = $query2->sum('berat');
            if (!$weightTotal) {
                $weightTotal = 0;
            }
            $todayTrxFee = $weightTotal * $query['value'];

            $out = [
                'success' => true,
                'data' => $todayTrxFee
            ];
        }
        
        return $out;
    }

    /**
     * get Today Weight
     */
    public function actionGetThisMonthWeight() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $month = date('n');
        if (Yii::$app->user->can('admin')) {
            $strWhere = "MONTH(tanggalinput)='$month'";
        }else {
            $user = User::findOne(Yii::$app->user->id);
            $strWhere = "MONTH(tanggalinput)='$month' AND banksampah_id=".$user->banksampah_id;
        }
        $query = (new \yii\db\Query())->from('orderdetail od')
                ->leftJoin('order o', 'orderid=idorder')
                ->where($strWhere);
        $weightTotal = $query->sum('od.berat');
        if (!$weightTotal) {
            $weightTotal = 0;
        }
        $out = [
            'success' => true,
            'data' => $weightTotal
        ];

        return $out;
    }
    /**
     * get Today Weight
     */
    public function actionGetThisMonthItem() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'success' => false,
            'data' => 0
        ];
        $month = date('n');
        if (Yii::$app->user->can('admin')) {
            $strWhere = "MONTH(tanggalinput)='$month'";
        }else {
            $user = User::findOne(Yii::$app->user->id);
            $strWhere = "MONTH(tanggalinput)='$month' AND banksampah_id=".$user->banksampah_id;
        }
        $query = (new \yii\db\Query())->from('orderdetail')
                ->leftJoin('order', 'orderid=idorder')
                ->where($strWhere);
        $itemTotal = $query->count('DISTINCT idsampah');
        if (!$itemTotal) {
            $itemTotal = 0;
        }
        $out = [
            'success' => true,
            'data' => $itemTotal
        ];

        return $out;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('user/login');
        }else {
            // if (!Yii::$app->user->can('admin')) { 
            //     $this->redirect(Yii::$app->user->getRedirect());
            // }else {
            //     return $this->render('index');
            // }
            return $this->render('index');
        }
    }

    public function actionTermCondition2() {
        $this->layout = 'empty';
        return $this->render('term-condition');
    }

    public function actionTermConditionOfficer2() {
        $this->layout = 'empty';
        return $this->render('term-condition-officer');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
