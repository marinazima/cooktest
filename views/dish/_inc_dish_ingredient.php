<?php
use app\models\Ingredient;

$state = isset($di) ? $di->isactive : 1;
$id=isset($di) ? $di->id : 0;
?>

<div class="x-dish-ing dish-ing <?= $state==1 ? 'dish-ing-success' : 'dish-ing-default' ?>" data-id="<?= $id ?>" data-ing_id="<?= $di->ingredient_id ?>" data-state="<?= $state ?>" <?= $id==0 ? 'style="display: none;"' : '' ?>>
    <span class="pull-right" title="Delete ingredient"><span class="glyphicon glyphicon-trash x-delete"></span></span>
    <span style="margin-right: 10px;" class="pull-right x-state" title="<?= ($state==1 ? 'Hide' : 'Show').' ingredient' ?>"><span class="glyphicon <?= $state==1 ? 'glyphicon-eye-open' : 'glyphicon-eye-close' ?> "></span></span>    
    <span style="margin-right: 25px;" class="x-label"><?= Ingredient::findOne($di->ingredient_id)->name ?></span>
</div>  