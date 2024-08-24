<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\AuthMaster;
use app\models\RoleAuth;
use app\modules\user\models\Role;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Inflector;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ProcessAuthMasterController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        $this->handleAuthMaster();
        $this->handleInitAuthAdmin();
        return ExitCode::OK;
    }

    private function handleInitAuthAdmin()
    {
        $role = Role::find()->where(['can_admin' => 1])->one();
        if ($role) {
            //init all auth master for default admin role
            $authMasterData = AuthMaster::find()->all();
            foreach ($authMasterData as $authMaster) {
                // echo 'this is auth master';
                // echo $authMaster->id;
                // echo '\n';
                $roleAuth = RoleAuth::find()->where([
                    'role_id' => $role->id, 
                    'auth_id' => $authMaster->id
                ])->one();
                if (!$roleAuth) {
                    $roleAuth = new RoleAuth();
                    $roleAuth->role_id = $role->id;
                    $roleAuth->auth_id = $authMaster->id;
                    $roleAuth->save();
                    echo "New role auth has been added for admin!\n";
                }
            }
        }
    }

    private function handleAuthMaster()
    {
        $basePath = Yii::$app->basePath;
        $controllerPath = $basePath . "/controllers/";
        $controllers = array_diff(scandir($controllerPath), array('.', '..'));
        $data = [];
        foreach ($controllers as $item) {
            $handle = fopen($controllerPath . $item, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)) :
                        if (strlen($display[1]) > 2) {
                            $controller = Inflector::camel2id(substr($item, 0, -4));
                            $controllerID = str_replace('-controller', '', $controller);
                            $data[$controllerID][] = Inflector::camel2id($display[1]);
                        }
                    endif;
                }
            }
            fclose($handle);
        }
        $keys = array_keys($data);
        foreach ($keys as $controllerID) {
            foreach ($data[$controllerID] as $actionID) {
                $authMaster = AuthMaster::find()->where([
                    'controller' => $controllerID,
                    'action' => $actionID
                ])->one();
                if ($authMaster) {
                    $authMaster->controller = $controllerID;
                    $authMaster->action = $actionID;
                    $authMaster->save();
                } else {
                    $authMaster = new AuthMaster();
                    $authMaster->controller = $controllerID;
                    $authMaster->action = $actionID;
                    $authMaster->save();
                    echo "Data $controllerID and $actionID has been saved!\n";
                }
                
            }
        }
        $this->savingProcess($data, false);

        $data = [];
        $modulePath = $basePath . "/modules/";
        if (file_exists($modulePath)) {
            $modules = array_diff(scandir($modulePath), array('.', '..'));
            foreach ($modules as $moduleItemID) {
                $controllerPath = $basePath . "/modules/" . $moduleItemID . "/controllers/";
                $controllers = array_diff(scandir($controllerPath), array('.', '..'));
                foreach ($controllers as $item) {
                    $handle = fopen($controllerPath . $item, "r");
                    if ($handle) {
                        while (($line = fgets($handle)) !== false) {
                            if (preg_match('/public function action(.*?)\(/', $line, $display)) :
                                if (strlen($display[1]) > 2) {
                                    $controller = Inflector::camel2id(substr($item, 0, -4));
                                    $controllerID = str_replace('-controller', '', $controller);
                                    $data[$moduleItemID][$controllerID][] = Inflector::camel2id($display[1]);
                                }
                            endif;
                        }
                    }
                    fclose($handle);
                }
            }
        }
        $this->savingProcess($data, true);
       
    }

    private function savingProcess($data, $isModule) {
        if ($isModule) {
            $keysModule = array_keys($data);
            foreach ($keysModule as $moduleID) {
                $controllerID = $data[$moduleID];
                $keysController = array_keys($data[$moduleID]);
                foreach ($keysController as $controllerID) {
                    $arrAction = $data[$moduleID][$controllerID];
                    foreach ($arrAction as $actionID) {
                        $authMaster = AuthMaster::find()->where([
                            'module' => $moduleID,
                            'controller' => $controllerID,
                            'action' => $actionID
                        ])->one();
                        if ($authMaster) {
                            $authMaster->module = $moduleID;
                            $authMaster->controller = $controllerID;
                            $authMaster->action = $actionID;
                            $authMaster->name = "Can access ". Inflector::id2camel($controllerID) ." ". Inflector::id2camel($actionID);
                            $authMaster->save();
                        } else {
                            $authMaster = new AuthMaster();
                            $authMaster->module = $moduleID;
                            $authMaster->controller = $controllerID;
                            $authMaster->action = $actionID;
                            $authMaster->name = "Can access ". Inflector::id2camel($controllerID) ." ". Inflector::id2camel($actionID);
                            $authMaster->save();
                            echo "Data $moduleID, $controllerID and $actionID has been saved!\n";
                        }
                    }
                }
            }
        }else {
            $keysController = array_keys($data);
            foreach ($keysController as $controllerID) {
                $arrAction = $data[$controllerID];
                foreach ($arrAction as $actionID) {
                    $authMaster = AuthMaster::find()->where([
                        'controller' => $controllerID,
                        'action' => $actionID
                    ])->one();
                    if ($authMaster) {
                        $authMaster->controller = $controllerID;
                        $authMaster->action = $actionID;
                        $authMaster->name = "Can access ". Inflector::id2camel($controllerID) ." ". Inflector::id2camel($actionID);
                        $authMaster->save();
                    } else {
                        $authMaster = new AuthMaster();
                        $authMaster->controller = $controllerID;
                        $authMaster->action = $actionID;
                        $authMaster->save();
                    }
                }
            }
        }
        
    }
}
