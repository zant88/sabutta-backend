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
    <?php 
    if (Yii::$app->user->canAccess('site/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'site' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/"]) ?>"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
      <?php
    }
    ?>
    <li class="menu-header">Master Data</li>
    <?php 
    if (Yii::$app->user->canAccess('fasyankes-user/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'fasyankes-user' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/fasyankes-user"]) ?>"><i class="fa fa-route"></i> <span>Pengguna</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('driver/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'driver' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/driver"]) ?>"><i class="fa fa-tasks"></i> <span>Pegawai</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('user/admin/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'admin' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/user/admin/"]) ?>"><i class="fa fa-tasks"></i> <span>Pengguna Backoffce</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('stock/card')) {
      ?>
    <li <?= Yii::$app->controller->action->id == 'card' && Yii::$app->controller->id == 'stock' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/stock/card"]) ?>"><i class="fa fa-tasks"></i> <span>Kartu Stok</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('waste-type/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'waste-type' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/waste-type"]) ?>"><i class="fa fa-tasks"></i> <span>Jenis Sampah</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('jenissampah/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'jenissampah' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/jenissampah"]) ?>"><i class="fa fa-tasks"></i> <span>Sampah</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('stock/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'stock' && Yii::$app->controller->action->id == 'index'? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/stock"]) ?>"><i class="fa fa-tasks"></i> <span>Transaksi Harian</span></a></li>
      <?php
    }
    ?>
    <!-- <?php 
    if (Yii::$app->user->canAccess('transaction/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'transaction' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/transaction"]) ?>"><i class="fa fa-tasks"></i> <span>Arus Kas</span></a></li>
      <?php
    }
    ?> -->
    <!-- <?php 
    if (Yii::$app->user->canAccess('vendor/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'vendor' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/vendor"]) ?>"><i class="fa fa-tasks"></i> <span>Vendor</span></a></li>
      <?php
    }
    ?> -->
    <!-- <?php 
    if (Yii::$app->user->canAccess('sales/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'sales' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/sales"]) ?>"><i class="fa fa-tasks"></i> <span>Penjualan</span></a></li>
      <?php
    }
    ?> -->
    <!-- <?php 
    if (Yii::$app->user->canAccess('invoice/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'invoice' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/invoice"]) ?>"><i class="fa fa-tasks"></i> <span>Invoice</span></a></li>
      <?php
    }
    ?> -->
    <!-- <?php 
    if (Yii::$app->user->canAccess('report/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'report' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/report"]) ?>"><i class="fa fa-tasks"></i> <span>Report</span></a></li>
      <?php
    }
    ?> -->
    <?php 
    if (Yii::$app->user->canAccess('withdraw/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'withdraw' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/withdraw"]) ?>"><i class="fa fa-tasks"></i> <span>Penarikan</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('order-revision/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'order-revision' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/order-revision"]) ?>"><i class="fa fa-tasks"></i> <span>Koreksi</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('role/index')) {
      ?>
    <li class="menu-header">Authorization</li>
    <li <?= Yii::$app->controller->id == 'role' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/role"]) ?>"><i class="fa fa-tasks"></i> <span>Role</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('auth-master/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'auth-master' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/auth-master"]) ?>"><i class="fa fa-tasks"></i> <span>Auth Master</span></a></li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('auth-master/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'role-auth' ? 'class="active"' : '' ?>><a class="nav-link" href="<?= Url::to(["/role-auth"]) ?>"><i class="fa fa-tasks"></i> <span>Role Auth</span></a></li>
      <?php
    }
    ?>
  </ul>
</aside>