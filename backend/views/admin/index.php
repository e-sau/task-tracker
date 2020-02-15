<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Admin Panel';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg">
                <h2>Приветствую тебя, <?= Yii::$app->user->identity->username ?>!</h2>
                <?= Html::a("Очистить кэш", ['clear-cache'],
                    [
                        "class" => "btn btn-warning btn-clear-cache"
                    ]
                ); ?>
            </div>
        </div>

    </div>
</div>
