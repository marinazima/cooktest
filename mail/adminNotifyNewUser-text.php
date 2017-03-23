<?php
$newuserLink = Yii::$app->urlManager->createAbsoluteUrl(['user/view', 'id' => $user->id]);
?>
 
Hello <?= $user->username ?>,
New user registered:
 
<?= $resetLink ?>
