<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IngredientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ingredients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ingredient', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'id','options' => ['width'=>'100']],
            'name',            
            ['attribute'=>'created_at', 
            'format' =>  ['datetime', 'Y-MM-dd HH:mm:ss'],
            'options' => ['width' => '200']
            ],
            ['attribute'=>'updated_at', 
            'format' =>  ['datetime', 'Y-MM-dd HH:mm:ss'],
            'options' => ['width' => '200']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],    
    ]); ?>
</div>
