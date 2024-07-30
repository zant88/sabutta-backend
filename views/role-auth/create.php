<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RoleAuth */

$this->title = Yii::t('app', 'Role Auth Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Role Auth'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="app-role">
  <div class="col-lg-8">
    <div class="role-auth-create">
      <div class="card">
        <div class="card-header">
          <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
          <div class="d-flex flex-column justify-content-end align-items-end">
            <div class="row w-100">
              <div class="col-lg-6">
                <label for="exampleFormControlInput1" class="form-label">Role</label>
                <select class="form-select form-control mb-3" @change="getCurrentRoleAuth" aria-label="Role name" v-model="role_id">
                  <option selected>- SELECT -</option>
                  <?php 
                    foreach ($role as $item) {
                      ?>
                      <option value="<?= $item->id ?>"><?= $item->name ?></option>  
                      <?php 
                    }
                  ?>
                </select>
              </div>
              <div class="col-lg-6">
                <label for="exampleFormControlInput1" class="form-label">Module</label>
                <select class="form-select form-control mb-3" @change="getRoleAuth" aria-label="Role name" v-model="module">
                  <option selected>- SELECT -</option>
                  <option value="-1">Root</option>
                  <?php 
                    foreach ($module as $item) {
                      ?>
                      <option value="<?= $item->module ?>"><?= $item->module ?></option>  
                      <?php 
                    }
                  ?>
                </select>
              </div>
              <div class="col-lg-12 row">
                <div v-for="(item, index) in auth_master" class="col-lg-4 mb-2">
                  <div class="form-check">
                    <input @change="toggleSelection(index)" class="form-check-input"  type="checkbox" :value="item.id">
                    <label class="form-check-label" for="flexCheckDefault">
                      {{ item.name }}
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="btn-container">
              <a v-if="auth_master_selected.length > 0" class="btn btn-success mt-5" @click="save" style="width: 100px;" @click="add">Submit</a>
              <a class="btn btn-primary mt-5" style="width: 100px;" @click="add">Add</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="col-lg-4">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md">
              <tbody>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Controller</th>
                  <th>Action</th>
                  <th>#</th>
                </tr>
                <tr v-for="(item, index) in auth_master_selected ">
                  <td>{{ index + 1}}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.controller }}</td>
                  <td>{{ item.action }}</td>
                  <td><a href="#" class="btn btn-secondary">x</a></td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md">
              <tbody>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Controller</th>
                  <th>Action</th>
                  <th>#</th>
                </tr>
                <tr v-for="(item, index) in auth_master_selected ">
                  <td>{{ index + 1}}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.controller }}</td>
                  <td>{{ item.action }}</td>
                  <td><a @click="remove(index, item.from_server)" class="btn btn-danger">x</a></td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
$this->registerJsFile(
  'https://unpkg.com/vue@2',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '@web/js/views/role-auth.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '//cdn.jsdelivr.net/npm/sweetalert2@11',
  ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->registerJsFile(
  '//cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js',
  ['depends' => [\yii\web\JqueryAsset::class]]
);
?>