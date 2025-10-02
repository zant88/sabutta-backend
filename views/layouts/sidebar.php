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
    <li <?= Yii::$app->controller->id == 'site' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/"]) ?>"><i class="fa fa-tachometer-alt"></i> <span>Dashboard</span></a>
    </li>
      <?php
    }
    ?>
    <li class="menu-header">Master Data</li>
    <?php 
    if (Yii::$app->user->canAccess('fasyankes-user/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'fasyankes-user' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/fasyankes-user"]) ?>"><i class="fa fa-users"></i> <span>Pengguna</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('driver/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'driver' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/driver"]) ?>"><i class="fa fa-id-card"></i> <span>Pegawai</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('user/admin/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'admin' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/user/admin/"]) ?>"><i class="fa fa-user-shield"></i> <span>Pengguna Backoffce</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('stock/card')) {
      ?>
    <li <?= Yii::$app->controller->action->id == 'card' && Yii::$app->controller->id == 'stock' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/stock/card"]) ?>"><i class="fa fa-clipboard-list"></i> <span>Kartu Stok</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('waste-type/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'waste-type' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/waste-type"]) ?>"><i class="fa fa-recycle"></i> <span>Jenis Sampah</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('jenissampah/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'jenissampah' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/jenissampah"]) ?>"><i class="fa fa-trash"></i> <span>Sampah</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->can('admin')) {
      ?>
    <li <?= Yii::$app->controller->id == 'banksampah' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/banksampah"]) ?>"><i class="fa fa-university"></i> <span>Bank Sampah</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('stock/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'stock' && Yii::$app->controller->action->id == 'index'? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/stock"]) ?>"><i class="fa fa-exchange-alt"></i> <span>Transaksi Harian</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (!Yii::$app->user->can('admin') && Yii::$app->user->canAccess('withdraw/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'withdraw' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/withdraw"]) ?>"><i class="fa fa-money-bill-wave"></i> <span>Penarikan</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('order-revision/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'order-revision' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/order-revision"]) ?>"><i class="fa fa-edit"></i> <span>Koreksi</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('banksampah-sales/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'banksampah-sales' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/banksampah-sales"]) ?>"><i class="fa fa-cash-register"></i> <span>Penjualan Bank Sampah</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('role/index')) {
      ?>
    <li class="menu-header">Authorization</li>
    <li <?= Yii::$app->controller->id == 'role' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/role"]) ?>"><i class="fa fa-user-tag"></i> <span>Role</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('auth-master/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'auth-master' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/auth-master"]) ?>"><i class="fa fa-key"></i> <span>Auth Master</span></a>
    </li>
      <?php
    }
    ?>
    <?php 
    if (Yii::$app->user->canAccess('auth-master/index')) {
      ?>
    <li <?= Yii::$app->controller->id == 'role-auth' ? 'class="active"' : '' ?>>
      <a class="nav-link" href="<?= Url::to(["/role-auth"]) ?>"><i class="fa fa-user-lock"></i> <span>Role Auth</span></a>
    </li>
      <?php
    }
    ?>
  </ul>
</aside>
