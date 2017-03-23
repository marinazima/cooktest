<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\Ingredient;

/**
 * This is the model class for table "dish_ingredient".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $dish_id
 * @property integer $ingredient_id
 * @property integer $isactive
 */
class DishIngredient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dish_ingredient';
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
            [['dish_id', 'ingredient_id'], 'required'],
            [['created_at', 'updated_at', 'dish_id', 'ingredient_id', 'isactive'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'dish_id' => 'Dish ID',
            'ingredient_id' => 'Ingredient ID',
            'isactive' => 'Isactive',
        ];
    }
   
}
