<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'project/index',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'dateFormat' => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                [
//                    'project/<id:\d+>'=>'project/view',
//                    'task/<id:\d+>'=>'task/view',
//                ],
                [
                    'controller' => 'api/task',
                    'class' => \yii\rest\UrlRule::class,
                    'extraPatterns' => [
                        'GET auth' => 'auth',
                    ],
                ]
            ],
        ],
        'chatComponent' => [
            'class' => 'frontend\components\Chat',
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class
        ],
        'lastVisited' => [
            'class' => \frontend\components\LastFiveVisitedTasks::class,
        ],
    ],
    'modules' => [
        'api' => [
            'class' => \frontend\modules\api\Module::class
        ],
    ],
    'params' => $params,
];
