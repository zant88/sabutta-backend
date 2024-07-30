<?php
namespace app\controllers;

use app\models\Vsumpilahan;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\MyController;

class ReportController extends MyController 
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
                        'actions' => ['earning', 'index', 'submit-password'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEarning() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'waste_amount' => 0,
            'waste_weight' => 0,
            'total_sales' => 0,
            'total_cashout' => 0
        ];
        if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
            $startDate = $_GET['start_date'];
            $endDate = $_GET['end_date'];

            $rows = (new \yii\db\Query())
                ->select(['SUM(nilai) as waste_amount', 'SUM(berat) as waste_weight'])
                ->from('vsumpilahan')
                ->where("tgl BETWEEN '$startDate' AND '$endDate'")
                ->one();
            $rowsSales = (new \yii\db\Query())
                ->select(['SUM(total) as total_sales'])
                ->from('sales')
                ->where("DATE(sales_date) BETWEEN '$startDate' AND '$endDate'")
                ->one();

            $rowsTransaction = (new \yii\db\Query())
                ->select(['SUM(cash_out) as total_cashout'])
                ->from('transaction')
                ->where("DATE(created_date) BETWEEN '$startDate' AND '$endDate'")
                ->one();

            $out['waste_amount'] = $rows['waste_amount'];
            $out['total_sales'] = $rowsSales['total_sales'];
            $out['total_cashout'] = $rowsTransaction['total_cashout'];
            $out['waste_weight'] = round($rows['waste_weight'], 2);
        }

        return $out;
    }

    public function actionIndex() {
        // if (Yii::$app->request->post()) {
        //     $data = Yii::$app->request->post();
        //     if ($data['passsword'] == 'passw0rd') {
        //         return $this->render('earning-report');
        //     }
        // }

        return $this->render('report-index');
    }

    public function actionSubmitPassword() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->post()) {
            $password = $_POST['password'];
            // echo $password;
            // die;
            if ($password == Yii::$app->params['report_password']) {
                return 1;
            }else {
                return 0;
            }
        }
    }
}

?>