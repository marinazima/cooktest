<?php
use yii\helpers\Html;
 
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->email_confirm_token]);
?>
 
<div class="email-confirm">
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>Follow the link below to confirm you registration:</p>
    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>