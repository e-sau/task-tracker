<?php

namespace frontend\modules\api\controllers;

use common\models\Task;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class TaskController extends ActiveController
{
    public $modelClass = Task::class;

    public function behaviors()
    {
        $parent = parent::behaviors();
        return array_merge($parent, [
//           'authenticator' => [
//               'class' => HttpBearerAuth::class,
//           ]
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['http://task-tracker.third', 'http://localhost:8080'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT'],
                    // Allow only headers 'X-Wsse'
//                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ]);
    }

    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws ForbiddenHttpException
     */
//    public function checkAccess($action, $model = null, $params = [])
//    {
//        if (in_array($action, [
//            'view',
//            'update',
//            'delete'
//        ])) {
//            /** @var Task $model */
//            if ($model->creator_id !== \Yii::$app->user->identity->id) {
//                throw new ForbiddenHttpException('Only author can view, update and delete tasks');
//            }
//        }
//    }

    public function actionAuth()
    {
        $user = \Yii::$app->user->identity;
        unset(
          $user['auth_key'],
          $user['password_hash'],
          $user['password_reset_token'],
          $user['verification_token'],
        );
        return $user;
    }
}