<?php

use yii\helpers\Html;
use app\models\Mbanksampah;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */

$this->title = Yii::t('app', 'Pegawai Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pegawai Driver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-create">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'mrole' => $mrole,
                        'bs_list' => Mbanksampah::dropdownCode(),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
