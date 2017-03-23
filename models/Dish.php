<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "dish".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $recipe
 */
class Dish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dish';
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
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['recipe'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'name' => 'Name',
            'recipe' => 'Recipe',
        ];
    }
    
    /*public function getDishIngredient()
    {
        return $this->hasMany(DishIngredient::className(), ['dish_id' => 'id']);
    }*/ 
    
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])
            ->viaTable('dish_ingredient', ['dish_id' => 'id']);
    }

    public function getActiveIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])
            ->viaTable('dish_ingredient', ['dish_id' => 'id'], 
                function($query) {
                    $query->onCondition(['isactive' =>1]);
                }                    
            );
    }  
}
