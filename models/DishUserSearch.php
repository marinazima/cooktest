<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dish;

/**
 * DishSearch represents the model behind the search form about `app\models\Dish`.
 */
class DishUserSearch extends Dish
{
    public $ingredients;
    public $noresults_message = 'No results';
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ingredients'], 'validateIngredients'],
            [['ingredients'], 'safe'],
        ];
    }

    public function validateIngredients($attribute, $params)
    {
        if(count($this->$attribute)<2){
            $this->addError('ingredients', 'Choose more ingredients');
        }
    }    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dish::find()
                ->joinWith('activeIngredients', true, 'INNER JOIN')
                ->distinct();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],              
        ]);
        
        //$this->load($params);
        $this->ingredients = $params["ingredients"];
        
        if (!$this->validate() || !isset($this->ingredients)) {
            // uncomment the following line if you do not want to return any records when validation fails
            $this->noresults_message = 'Please choose more ingredients';
            $query->where('0=1');           
            return $dataProvider;
        }

        //var_dump($this->ingredients);
        if(isset($this->ingredients)){            
            $query->andWhere(['in', 'ingredient.id', $this->ingredients])->groupBy('dish.id');        

            //full match
            $dataProvider = self::getFullMatch($query, $this->ingredients);
            
            //partial match
            if($dataProvider->totalCount == 0){
                $dataProvider = self::getPartialMatch($query);
            }
            //var_dump($query->createCommand()->getRawSql());
        }
        
        return $dataProvider;
    }
    
    public static function getFullMatch($query, $ingredients){
        $query->having('count(ingredient.id)='.count($ingredients));
        
        return $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],              
        ]); 
    }
    
    public static function getPartialMatch($query){
        $query->having('count(ingredient.id)>=2')->orderBy('count(ingredient.id) DESC');
        
        return $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],              
        ]);         
    }    
}
