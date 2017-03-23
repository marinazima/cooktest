<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\ArrayHelper;

//var_dump($model->ingredients); die;
?>
 
<div class="news-item">
    <h2><?= Html::encode($model->name) ?></h2>    
    <h4><?= Html::encode( implode(', ',ArrayHelper::getColumn($model->activeIngredients, 'name')) ) ?></h4>    
    <?= HtmlPurifier::process($model->recipe) ?>    
</div>
