<?php
namespace app\models;
 
use Yii;
use yii\base\Model;
use app\models\User;
 
/**
 * Signup form
 */
class SignupForm extends Model
{
 
    public $username;
    public $email;
    public $password;
    public $password_confirm;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]{3,255}$#i', 'message'=>'Username should be min 3 characters, only allowed letters, numbers, dashes and underscores'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'This username has already been taken.'],
 
            ['username', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'This email address has already been taken.'],
            ['email', 'string', 'max' => 255, 'message'=>'Email is too long (max 255 characters)'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],  
            
            ['password_confirm', 'required'],
            ['password_confirm', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ]          
        ];
    }
 
    /**
     * Registers new user.
     *
     * @return true|false
     */
    public function signupUser()
    {
        if($this->validate()){
            $model = new User();
            $model->username = $this->username;
            $model->email = $this->email;
            $model->setPassword($this->password);

            $model->generateAuthKey();
            $model->generateEmailConfirmationToken();
        
            if($model->save()){
                $model->trigger(User::EVENT_NEW_USER); 
                return true;
            }
        }
        
        return false;
    }

}

