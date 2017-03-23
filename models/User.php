<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\db\Expression;
use \yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email_confirm_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_AWAITING_CONFIRMATION = 0;
    const STATUS_ACTIVE = 1;
    
    const EVENT_NEW_USER = 'new-user';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    // 
    public function init(){
        //bind handlers to event
        //first parameter is the name of the event and second is the handler.
        $this->on(self::EVENT_NEW_USER, [$this, 'sendMailUserEmailConfirm']);
        $this->on(self::EVENT_NEW_USER, [$this, 'sendMailAdminNotifyNewUser']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_AWAITING_CONFIRMATION],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],            
        ];  
    }

    /**
     * @inheritdoc
     */
    /*public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email_confirm_token' => 'Email Confirm Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }*/
    
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }
 
    public static function getStatusesArray()
    {
        return [
            self::STATUS_AWAITING_CONFIRMATION => 'Awaiting confirmation',
            self::STATUS_ACTIVE => 'Active',
        ];
    } 
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
 
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
 
    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }  
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
 
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    } 
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
 
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
 
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }   
        
    public function generateEmailConfirmationToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString() . '_' . time();
    }   
    
    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByEmailConfirmToken($token)
    {
        return static::findOne([
            'email_confirm_token' => $token,
            'status' => self::STATUS_AWAITING_CONFIRMATION,
        ]);
    }
    
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }  
    
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }
    
    public function activateUser(){
        $this->status = self::STATUS_ACTIVE;
        $this->removeEmailConfirmToken();
        return true;
    }
    
    /**
    * Sends email confirmation email to to user 
    */   
    public function sendMailUserEmailConfirm($event){
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'],
                ['user' => $event->sender]
            )
            ->setFrom([Yii::$app->params['robotEmail'] => Yii::$app->name . ' robot'])
            ->setTo($event->sender->email)
            ->setSubject('Email confirmation for ' . Yii::$app->name)
            ->send();
    }    
    /**
    * Sends email to admin about new user signup
    */    
    public function sendMailAdminNotifyNewUser($event){
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'adminNotifyNewUser-html', 'text' => 'adminNotifyNewUser-text'],
                ['user' => $event->sender]
            )
            ->setFrom([Yii::$app->params['robotEmail'] => Yii::$app->name . ' robot'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('New use registered on ' . Yii::$app->name)
            ->send();
    }
    
}
