<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
        
        // create admin role
        $admin = $auth->createRole('admin');        
        $auth->add($admin);
        
        // create permissions
        $accessAdminPanel = $auth->createPermission('accessAdminPanel');
        $accessAdminPanel->description = 'access to Admin panel';                
        $auth->add($accessAdminPanel);
        
        // add inheritance        
        // role admin add permission access admin panel
        $auth->addChild($admin,$accessAdminPanel);

        // assign role to admin user
        $user = User::findByUsername('admin');
        $auth->assign($admin, $user->id);
        
        echo 'Completed';
    }
}