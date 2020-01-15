<?php

namespace frontend\components;


use yii\base\Component;

class Chat extends Component
{
    public function showChat()
    {
        ob_start();
        require './../views/chat/index.php';
        ob_end_flush();
    }
}