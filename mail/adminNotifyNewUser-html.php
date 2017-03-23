<?php
use yii\helpers\Html;
 
$newuserLink = Yii::$app->urlManager->createAbsoluteUrl(['user/view', 'id' => $user->id]);
?>
 
<div class="email-confirm">
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>New user registered:</p>
    <p><?= Html::a(Html::encode($newuserLink), $newuserLink) ?></p>
</div>