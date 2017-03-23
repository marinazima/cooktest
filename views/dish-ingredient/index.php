<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dish Ingredients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-ingredient-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dish Ingredient', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'updated_at',
            'dish_id',
            'ingredient_id',
            // 'isactive',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
