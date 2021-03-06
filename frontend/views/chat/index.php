<div class="row">
    <div class="col-lg-9">
        <?= \yii\helpers\Html::textInput('message', '', ['id' => 'message', 'class' => 'form-control'])?>
    </div>

    <div class="col-lg-3">
        <?= \yii\helpers\Html::button('Отправить', ['id' => 'send', 'class' => 'btn btn-primary'])?>
    </div>
</div>
<div id="chat" style="max-height: 120px; border-color: #1c7430; border: 2px; overflow-y: scroll;"></div>
<div id="response" style="color:#D00"></div>
<?php if (Yii::$app->user->isGuest) {
    $username = 'guest' . time();
} else {
    $username = Yii::$app->user->identity->username;
} ?>
<?= \yii\helpers\Html::hiddenInput('username', $username, ['class' => 'js-username']) ?>