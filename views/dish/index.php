<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DishSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dishes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'id','options' => ['width'=>'100']],
            'name',
            [
                'attribute'=>'ingredients',
                'value'=>function($data){
                    return implode(',',ArrayHelper::getColumn($data->ingredients,'name'));
                }
            ],
            
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
