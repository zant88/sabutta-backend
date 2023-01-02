<?php

namespace app\modules\user\components;

use Yii;
use app\models\AuthMaster;
use app\models\RoleAuth;
use app\modules\user\models\User as UserModel;
use yii\helpers\Inflector;

/**
 * User component
 */
class User extends \yii\web\User
{
    /**
     * @inheritdoc
     */
    public $identityClass = 'app\modules\user\models\User';

    /**
     * @inheritdoc
     */
    public $enableAutoLogin = true;

    /**
     * @inheritdoc
     */
    public $loginUrl = ["/user/login"];

    /**
     * @inheritdoc
     */
    public function getIsGuest()
    {
        /** @var \amnah\yii2\user\models\User $user */

        // check if user is banned. if so, log user out and redirect home
        // https://github.com/amnah/yii2-user/issues/99
        $user = $this->getIdentity();
        if ($user && $user->banned_at) {
            $this->logout();
            Yii::$app->getResponse()->redirect(['/'])->send();
        }

        return $user === null;
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public function getIsLoggedIn()
    {
        return !$this->getIsGuest();
    }

    /**
     * @inheritdoc
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        /** @var \amnah\yii2\user\models\User $identity */
        $identity->updateLoginMeta();
        parent::afterLogin($identity, $cookieBased, $duration);
    }

    /**
     * Get user's display name
     * @return string
     */
    public function getDisplayName()
    {
        /** @var \amnah\yii2\user\models\User $user */
        $user = $this->getIdentity();
        return $user ? $user->getDisplayName() : "";
    }

    /**
     * Check if user can do $permissionName.
     * If "authManager" component is set, this will simply use the default functionality.
     * Otherwise, it will use our custom permission system
     * @param string $permissionName
     * @param array $params
     * @param bool $allowCaching
     * @return bool
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        // check for auth manager to call parent
        $auth = Yii::$app->getAuthManager();
        if ($auth) {
            return parent::can($permissionName, $params, $allowCaching);
        }

        // otherwise use our own custom permission (via the role table)
        /** @var \amnah\yii2\user\models\User $user */
        $user = $this->getIdentity();
        return $user ? $user->can($permissionName) : false;
    }

    public function getRole() {
        $user = UserModel::find()->joinWith(['role'])
            ->where([
                'user.id' => Yii::$app->user->id
            ])->one();
        if ($user) {
            $roleName = Inflector::camel2id(str_replace(" ", "", $user->role->name));
            return $roleName;
        }else {
            return null;
        }
    }
    public function getRedirect() {
        $user = UserModel::find()->joinWith(['role'])
            ->where([
                'user.id' => Yii::$app->user->id
            ])->one();
        if ($user) {
            return $user->role->redirect_path;
        }else {
            return null;
        }
    }

    public function canAccess($path) {
        $arrPath = explode("/", $path);
        if (sizeof($arrPath) == 3) {
            $moduleID = $arrPath[0];
            $controllerID = $arrPath[1];
            $actionID = $arrPath[2];
            $authMaster = AuthMaster::find()
                ->where([
                    'module' => $moduleID,
                    'controller' => $controllerID,
                    'action' => $actionID  
                ])->one();
        }else {
            $controllerID = $arrPath[0];
            $actionID = $arrPath[1];
            $authMaster = AuthMaster::find()
                ->where([
                    'controller' => $controllerID,
                    'action' => $actionID  
                ])->one();
        }
        $userID = \Yii::$app->user->id;
        
        $user = UserModel::find()
            ->where([
                'id' => $userID
            ])->one();
        $userRole = RoleAuth::find()
            ->where([
                'role_id' => $user->role_id,
                'auth_id' => $authMaster->id
            ])->one();
                
        if ($userRole) {
            return true;
        }else {
            return false;
        }
    }
}
