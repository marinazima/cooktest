<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ingredient;
use app\models\DishIngredient;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/dish.js', ['depends' => 'yii\web\JqueryAsset']);

//$ingredients = ArrayHelper::map(Ingredient::find()->all(), 'id', 'name');
$ingredients = Ingredient::find()->all();
//$dish_ingredients = DishIngredient::find(['dish_id'=>$model->id])->all();

//var_dump($model->dish_ingredients);die;
?>

<!-- Modal -->
<div class="modal fade" id="modIngredients" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Choose ingredients</h4>
      </div>
      <div class="modal-body" style="height: auto;">
          <ul class="multicol mc-quin"><li>
          <?php foreach($ingredients as $ing) { ?>
            <?= Html::checkbox('ingredients[]', in_array($ing->id, (isset($model->dish_ingredients) ? ArrayHelper::getColumn($model->dish_ingredients, 'ingredient_id') : [] )), ['value'=>$ing->id, 'label' => $ing->name, 'class'=>'x-ing']); ?>
            </li><li>
          <?php } ?>          
          </li></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="b-add-to-dish" type="button" class="btn btn-primary">Add to dish</button>
      </div>
    </div>
  </div>
</div>

<div class="dish-form">
    <?php //$form = ActiveForm::begin(); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'create-form',
        'action' => $model->isNewRecord ? ['create'] : ['update', 'id'=>$model->id],
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,                  
    ]); ?>    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
            <?= $form->field($model, 'dish_ingredients')->hiddenInput()->label(false); ?>
                
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'recipe')->textarea(['rows' => 6]) ?>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <div class="pull-left"><strong>Ingredients</strong></div>
                      <div class="pull-right">
                          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modIngredients"><span class="glyphicon glyphicon-plus"></span> Add ingredients</button>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="panel-body x-dish-ingredients">
                        <?php 
                        echo $this->render('_inc_dish_ingredient', []); 

                        if(isset($model->dish_ingredients)) foreach($model->dish_ingredients as $di){             
                            echo $this->render('_inc_dish_ingredient', [
                                'di'=>$di,
                            ]);            
                        }

                        ?>                                                                      
                    </div>
                </div>                
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>            
        </div>
    </div>    
    <?php ActiveForm::end(); ?>

</div>
