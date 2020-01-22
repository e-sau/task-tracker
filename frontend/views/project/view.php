<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'creator_id',
            [
                'attribute' => 'creator.username',
                'label' => 'Creator'
            ],
            'title',
            'description:ntext',
//            'priority_id',
            [
                'attribute' => 'priority.title',
                'label' => 'Priority'
            ],
//            'status',
            [
                'attribute' => 'status',
                'value' => function(\common\models\Project $model) {
                    return $model->getStatusTitle()[$model->status];
                }
            ],
//            'parent_project_id',
            [
                'attribute' => 'parent_project_id',
                'label' => 'Parent Project',
                'value' => Html::a(\common\models\Project::findOne($model->parent_project_id)->title,
                    ['project/view', 'id' => $model->parent_project_id]),
                'format' => 'raw'
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>


    <h3>Project Tasks:</h3>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->id];
        },
        'columns' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => function(\common\models\Task $model) {
                    return $model->getStatusTitle()[$model->status];
                }
            ],
        ],
    ]); ?>

</div>
<?= \frontend\widgets\chat\Chat::widget(['project_id' => $model->id]) ?>
