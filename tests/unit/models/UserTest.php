<?php
namespace tests\models;
use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentity(999));
    }

    /*public function testFindUserByAccessToken()
    {
        expect_that($user = User::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentityByAccessToken('non-existing'));        
    }*/

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('admin'));
        expect($user->username)->equals('admin');
        
        expect_not(User::findByUsername('not-admin'));
    }

    public function testFindUserByEmail()
    {
        expect_that($user = User::findByEmail('admin@newstest.loc'));
        expect($user->username)->equals('admin');
        
        expect_not(User::findByEmail('not-admin@newstest.loc'));
    }
    
    public function testValidateAuthKey(){
        $user = User::findByUsername('admin');
        expect_that($user->validateAuthKey($user->auth_key));
        expect_not($user->validateAuthKey('somekey'));
    }
    
    public function testValidatePassword(){
        $user = User::findByUsername('admin');
        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('somepassword'));
    }
    
    /*public function testFindByPasswordResetToken(){
        
        $token = ''; //put token of user with username 'testtoken'
        expect_that($user = User::findByPasswordResetToken($token));
        expect($user->username)->equals('testtoken');
        
        $sometoken = Yii::$app->security->generateRandomString() . '_' . time();
        expect_not(User::findByPasswordResetToken($sometoken));        
    }*/

}
