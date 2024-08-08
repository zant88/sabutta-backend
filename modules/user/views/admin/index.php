<?php

use app\models\Mbanksampah;
use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\search\UserSearch $searchModel
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Role $role
 */

$module = $this->context->module;
$user = $module->model("User");
$role = $module->model("Role");

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;


if (Yii::$app->user->can("admin")) {
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'role_id',
            'label' => Yii::t('user', 'Role'),
            'filter' => $role::dropdown(),
            'value' => function($model, $index, $dataColumn) use ($role) {
                $roleDropdown = $role::dropdown();
                return $roleDropdown[$model->role_id];
            },
        ],
        [
            'attribute' => 'status',
            'label' => Yii::t('user', 'Status'),
            'filter' => $user::statusDropdown(),
            'value' => function($model, $index, $dataColumn) use ($user) {
                $statusDropdown = $user::statusDropdown();
                return $statusDropdown[$model->status];
            },
        ],
        'email:email',
        'profile.full_name',
        [
            'attribute' => 'banksampah_id',
            'label' => Yii::t('user', 'Nama Bank Sampah'),
            'filter' => Mbanksampah::dropdown(),
            'value' => function($model, $index, $dataColumn) use ($role) {
               return $model->banksampah_id != null ? $model->bS->full_name : '-';
            },
        ],
        'created_at',

        ['class' => 'yii\grid\ActionColumn'],
    ];
}else {
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'role_id',
            'label' => Yii::t('user', 'Role'),
            'filter' => $role::dropdown(),
            'value' => function($model, $index, $dataColumn) use ($role) {
                $roleDropdown = $role::dropdown();
                return $roleDropdown[$model->role_id];
            },
        ],
        [
            'attribute' => 'status',
            'label' => Yii::t('user', 'Status'),
            'filter' => $user::statusDropdown(),
            'value' => function($model, $index, $dataColumn) use ($user) {
                $statusDropdown = $user::statusDropdown();
                return $statusDropdown[$model->status];
            },
        ],
        'email:email',
        'profile.full_name',
        'created_at',

        ['class' => 'yii\grid\ActionColumn'],
    ];
}
?>

<div class="user-index">
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a(Yii::t('user', 'Create {modelClass}', [
                'modelClass' => 'User',
                ]), ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php \yii\widgets\Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
            ]); ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>
