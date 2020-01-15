<?php

namespace console\controllers;

use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionInit()
    {
        $role = \Yii::$app->authManager->createRole('admin');
        $role->description = 'admin';
        \Yii::$app->authManager->add($role);

        $role = \Yii::$app->authManager->createRole('user');
        $role->description = 'user';
        \Yii::$app->authManager->add($role);
    }
}