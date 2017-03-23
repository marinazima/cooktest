<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \yii\db\Query;
use yii\helpers\Json;
use app\models\DishIngredient;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dish".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $recipe
 */
class DishForm extends Model
{
    public $id;
    public $name;
    public $recipe;
    public $created_at;
    public $updated_at;
    
    public $dish_ingredients; 
    
    public $isNewRecord = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['recipe'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['dish_ingredients'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    /*public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'name' => 'Name',
            'recipe' => 'Recipe',
        ];
    }*/
    
    public function save() {
        if ($this->validate()) {
            if($this->isNewRecord){
                $model = new Dish();
            }else{
                $model = Dish::findOne($this->id);
            }
            
            $model->name = $this->name;            
            $model->recipe = $this->recipe;
            $model->save();
            if($this->isNewRecord){ $this->id = $model->getPrimaryKey(); }
            
            $ex_di = ArrayHelper::GetColumn(DishIngredient::findAll(['dish_id'=>$this->id]),'id');            
            $new_di = Json::decode($this->dish_ingredients);
            foreach($new_di as $di){
                if($di["id"]==0){
                    $modelDi = new DishIngredient();
                    $modelDi->dish_id = $this->id;
                }else{
                    $modelDi = DishIngredient::findOne($di["id"]);
                    $key = array_search($di["id"], $ex_di);
                    if ($key !== false){ unset($ex_di[$key]); }
                }
                $modelDi->ingredient_id = $di["ingredient_id"];
                $modelDi->isactive = $di["isactive"];
                $modelDi->save();
            }
            foreach($ex_di as $ex_di_id){
                DishIngredient::findOne($ex_di_id)->delete();
            }
            
            return true;
        }
        return false;
    }
    
    public static function findOne($id){
        $dish = Dish::findOne($id);
        
        $model = new DishForm();
        
        $model->id =$dish->id;
        $model->name = $dish->name;
        $model->recipe = $dish->recipe;
        $model->created_at = $dish->created_at;
        $model->updated_at = $dish->updated_at;
        
        $model->dish_ingredients = DishIngredient::findAll(['dish_id'=>$id]);
        
        return $model;
    }  

    public function getDishIngredientsAsString($htmlmode=false){
        $label = [];
        foreach($this->dish_ingredients as $di){    
            $name = Ingredient::findOne($di->ingredient_id)->name;
            $label[] = $htmlmode ? '<span class="'.($di->isactive==0 ? 'dish-ing-inactive' : 'dish-ing-active').'">'.$name.'</span>' : $name;
        }
        return implode(',', $label);
    }    
}
