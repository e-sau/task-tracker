<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Site controller
 */
class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'clear-cache'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionClearCache()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (Yii::$app->cache->flush()) {
                return [
                    "status" => "200",
                    "message" => "Кэш очищен"
                ];
            }
            return [
                "status" => "500",
                "message" => "Ошибка очистки кэша"
            ];

        }
        return $this->redirect('index');
    }
}
