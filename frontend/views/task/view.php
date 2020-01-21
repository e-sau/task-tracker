<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

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
            'title',
            [
                'attribute' => 'status',
                'value' => function(\common\models\Task $model) {
                    return $model->getStatusTitle()[$model->status];
                }
            ],
            'description:ntext',
            [
                'attribute' => 'creator.username',
                'label' => 'Creator'
            ],
            [
                'attribute' => 'performer.username',
                'label' => 'Performer'
            ],
            [
                'attribute' => 'priority.title',
                'label' => 'Priority'
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'is_template:boolean'

        ],
    ]) ?>

</div>
