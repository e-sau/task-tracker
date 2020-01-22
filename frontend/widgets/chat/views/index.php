<div id="chat">
    <div class="chat__frame"></div>
    <div class="chat__form">
        <?= \yii\helpers\Html::textInput('message', '', [
            'id' => 'message',
            'class' => 'form-control'
        ])?>
        <div class="chat__buttons">
            <?= \yii\helpers\Html::button('Отправить', [
                'id' => 'send',
                'class' => 'btn btn-primary'
            ])?>
            <?= \yii\helpers\Html::button('Скрыть', [
                'id' => 'send',
                'class' => 'btn btn-info btn-hide'
            ])?>
        </div>
    </div>
</div>
<?= \yii\helpers\Html::button('Чат', [
    'class' => 'btn btn-info show-chat'
])?>
