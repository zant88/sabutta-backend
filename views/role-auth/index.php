<?php


use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;
use app\modules\user\models\Role;
use app\widgets\grid\ActionColumn;

$gridColumns=[['class' => 'yii\grid\SerialColumn'], 
            [
                'attribute' => 'role',
                'label' => 'Role',
                'value' => function($data) {
                    if ($data->role_id != null) {
                        return Role::findOne($data->role_id)->name;
                    }else {
                        return '-';
                    }
                }
            ],
            [
                'attribute' => 'auth',
                'label' => 'Auth Name',
                'value' => function($data) {
                    return $data->auth->name;
                }
            ],
            [
                'label' => 'Module',
                'value' => function($data) {
                    return $data->auth->module ? $data->auth->module : '-';
                }
            ],
            [
                'label' => 'Controller',
                'value' => function($data) {
                    return $data->auth->controller;
                }
            ],
            [
                'label' => 'Action',
                'value' => function($data) {
                    return $data->auth->controller;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template'=>'{delete}',
            ],


//  ['class' => 'app\widgets\grid\ActionColumn'],

];
/* @var $this yii\web\View */
/* @var $searchModel app\models\RoleAuthSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Daftar Role Auth');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-auth-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="card">
    <div class="card-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>  
    <div class="card-body">
    <p> 
        <?=  Html::a(Yii::t('app', 'Role Auth Baru'), ['create'], ['class' => 'btn btn-success']) ?>
   
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,      
    ]); ?>
    </div>
</div>
    <?php Pjax::end(); ?>
</div>
