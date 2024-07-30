<?php
namespace app\components;

use Yii;
use app\models\AuthMaster;
use app\modules\user\models\User;
use app\models\RoleAuth;
use app\modules\user\models\Role;
use yii\web\HttpException;

class MyController extends \yii\web\Controller
{
    public function beforeAction($action){
        if (!Yii::$app->user->isGuest) {
            $user_id = \Yii::$app->user->id;
            $module_id = Yii::$app->controller->module->id;
            $controller_id = Yii::$app->controller->id;
            $action_id = Yii::$app->controller->action->id;
            if ($action_id != 'error' && $action_id != 'term-condition-2' && $action_id != 'term-condition-officer-2') {
                if ($module_id == Yii::$app->id) {
                    $auth_master = AuthMaster::find()
                        ->where([
                            'controller' => $controller_id,
                            'action' => $action_id  
                        ])->one();
                }else {
                    $auth_master = AuthMaster::find()
                        ->where([
                            'module' => $module_id,
                            'controller' => $controller_id,
                            'action' => $action_id  
                        ])->one();
                }

                $user_role = null;

                if ($auth_master) {
                    $user = User::find()
                        ->where([
                            'id' => $user_id
                        ])
                        ->one();
                    
                    $user_role = RoleAuth::find()
                        ->where([
                            'role_id' => $user->role_id,
                            'auth_id' => $auth_master->id
                        ])->one();
                    if(!$user_role){
                        if ($controller_id == 'site' && $action_id == 'index') {
                            $user = User::findOne($user_id);
                            $role = Role::findOne($user->role_id);
                            if ($role->redirect_path) {
                                
                            
                                return $this->redirect([$role->redirect_path]);
                            }
                        }else {
                            throw new HttpException(403, 'You are not allowed to perform this action.');
                        }
                        throw new HttpException(403, 'You are not allowed to perform this action.');
                    }
                }else {
                    if ($controller_id == 'site' && $action_id == 'index') {
                        $user = User::findOne($user_id);
                        $role = Role::findOne($user->role_id);
                        if ($role->redirect_path) {
                            return $this->redirect([$role->redirect_path]);
                            // return parent::beforeAction($action);
                        }
                    }else {
                        throw new HttpException(403, 'You are not allowed to perform this action.');
                    }
                }
            }   
        }
            
        return parent::beforeAction($action);
    }
}

?>