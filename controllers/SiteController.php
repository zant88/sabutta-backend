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
        $query = (new \yii\db\Query())->from('order')
            ->where("MONTH(tanggalinput)='$month'");
        $weightTotal = $query->sum('berat');
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
