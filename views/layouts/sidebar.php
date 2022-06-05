<?php

use yii\helpers\Url;

?>
<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?= Url::to(["/"]) ?>">Sabutta</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="<?= Url::to(["/"]) ?>">S</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li <?= Yii::$app->controller->id == 'site' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/"]) ?>"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
    <li class="menu-header">Master Data</li>
    <li <?= Yii::$app->controller->id == 'fasyankes-user' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/fasyankes-user"]) ?>"><i class="fa fa-route"></i> <span>Pengguna</span></a></li>
    <li <?= Yii::$app->controller->id == 'driver' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/driver"]) ?>"><i class="fa fa-tasks"></i> <span>Pegawai</span></a></li>
    <li <?= Yii::$app->controller->action->id == 'card' && Yii::$app->controller->id == 'stock' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/stock/card"]) ?>"><i class="fa fa-tasks"></i> <span>Kartu Stok</span></a></li>
    <li <?= Yii::$app->controller->id == 'waste-type' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/waste-type"]) ?>"><i class="fa fa-tasks"></i> <span>Jenis Sampah</span></a></li>
    <li <?= Yii::$app->controller->id == 'jenissampah' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/jenissampah"]) ?>"><i class="fa fa-tasks"></i> <span>Sampah</span></a></li>
    <li <?= Yii::$app->controller->id == 'stock' && Yii::$app->controller->action->id == 'index'? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/stock"]) ?>"><i class="fa fa-tasks"></i> <span>Transaksi Sampah</span></a></li>
    <li <?= Yii::$app->controller->id == 'transaction' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/transaction"]) ?>"><i class="fa fa-tasks"></i> <span>Arus Kas</span></a></li>
    <li <?= Yii::$app->controller->id == 'vendor' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/vendor"]) ?>"><i class="fa fa-tasks"></i> <span>Vendor</span></a></li>
    <li <?= Yii::$app->controller->id == 'sales' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/sales"]) ?>"><i class="fa fa-tasks"></i> <span>Penjualan</span></a></li>
    <li <?= Yii::$app->controller->id == 'report' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/report"]) ?>"><i class="fa fa-tasks"></i> <span>Report</span></a></li>
  </ul>
</aside>