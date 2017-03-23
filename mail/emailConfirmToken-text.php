<?php
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->email_confirm_token]);
?>
 
Hello <?= $user->username ?>,
Follow the link below to confirm you registration:
 
<?= $resetLink ?>
