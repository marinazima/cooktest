<?php
use yii\helpers\Html;

use yii\widgets\ListView;
/* @var $this yii\web\View */
$this->registerJsFile('@web/js/dish-user.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'My Yii Application';
$selected = isset($searchModel->ingredients) ? $searchModel->ingredients : [];
        
?>
<!-- alert -->
<div id="alertTooManyIngredients" class="alert alert-danger" style="display: none;">
  <strong>Attention!</strong> You cannot choose more than 5 ingredients.
    <button type="button" class="close" data-hide="alert" aria-hidden="true">&times;</button>  
</div>

<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Choose Ingredients</h3>
                </div>
                <?= Html::beginForm(['site/index'], 'post', ['enctype' => 'multipart/form-data', 'id'=>'form-index']) ?>
                <div class="panel-body">
                    <ul class="multicol mc-quin"><li>
                    <?php foreach($ingredients as $ing) { ?>
                        <?= Html::checkbox('ingredients[]', in_array($ing->id, $selected), ['value'=>$ing->id, 'label' => $ing->name, 'class'=>'x-ing']); ?>
                        </li><li>    
                    <?php } ?>
                    </li></ul>
                </div>
                <div class="panel-footer">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id'=>'b-submit']) ?>    
                </div>  
                <?= Html::endForm() ?> 
            </div>
        </div>
        <div class="row">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'emptyText'=> $searchModel->noresults_message
    ]); ?>            
        </div>
    </div>
</div>
