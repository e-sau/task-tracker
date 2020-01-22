<?php

namespace frontend\widgets\chat;

class ChatAsset extends \yii\web\AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';
    public $css = [
        'css/chat.css',
    ];
    public $js = [
        'js/chat.js'
    ];
    public $depends = [
        \yii\web\YiiAsset::class
    ];
}