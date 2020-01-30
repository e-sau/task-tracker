<?php

namespace frontend\controllers;

use frontend\models\ChatLog;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ChatLog::create([
                'created_at' => \Yii::$app->formatter->format(time(), [
                    'datetime',
                    'php:d.m.Y H:i:s'
                ]),
                'message' => "Task: '[{$model->id}]{$model->title}' was created!",
                'username' => 'System',
                'type' => ChatLog::SEND_MESSAGE
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $templates = Task::find()->andWhere(['is_template' => true])->all();
        $templates = ArrayHelper::map($templates, 'id', 'title');
      
        return $this->render('create', [
            'model' => $model,
            'templates' => $templates
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ChatLog::create([
                'created_at' => \Yii::$app->formatter->format(time(), [
                    'datetime',
                    'php:d.m.Y H:i:s'
                ]),
                'message' => "Task: '[{$model->id}]{$model->title}' was updated!",
                'username' => 'System',
                'type' => ChatLog::SEND_MESSAGE
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $templates = Task::find()->andWhere(['is_template' => true])->all();
        $templates = ArrayHelper::map($templates, 'id', 'title');

        return $this->render('update', [
            'model' => $model,
            'templates' => $templates
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetTemplate()
    {
        $template_id = Yii::$app->request->post('template_id');
        $task = new Task();
        $task->template_id = $template_id;
        $template = $task->template;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $template ?: ['error' => 'Template is not exist'];
    }
}
