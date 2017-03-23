<?php

use yii\db\Migration;
use yii\db\Expression;
use app\models\User;

class m170318_214010_user_insert_admin extends Migration
{
    public function up()
    {
        $username = 'admin';
        
        $model = User::findByUsername($username);
        if(empty($model)){
            $this->insert('{{%user}}',array(
                'created_at'=>new Expression('UNIX_TIMESTAMP(NOW())'), 
                'updated_at' =>new Expression('UNIX_TIMESTAMP(NOW())'),
                'username'=>$username,
                'auth_key' => Yii::$app->security->generateRandomString(),
                'password_hash'=> Yii::$app->security->generatePasswordHash($username),
                'email' => Yii::$app->params['adminEmail'],
                'status' => User::STATUS_ACTIVE,
            ));
        }
    }

    public function down()
    {
        $this->delete('{{%user}}', ['username'=>'admin']);
    }
}
