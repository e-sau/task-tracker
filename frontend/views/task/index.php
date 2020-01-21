<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->id];
        },
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'status',
                'value' => function(\common\models\Task $model) {
                    return $model->getStatusTitle()[$model->status];
                }
            ],
//            'description:ntext',
//            'creator_id',
            [
                'attribute' => 'performer.username',
                'label' => 'Performer'
            ],
            [
                'attribute' => 'priority.title',
                'label' => 'Priority'
            ],
            //'created_at',
            //'updated_at',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<?php
$this->registerJs("

    $('td').click(function (e) {
        var id = $(this).closest('tr').data('id');
        if(id && e.target == this)
            location.href = '" . \yii\helpers\Url::to(['task/view']) . "?id=' + id;
    });

");

$this->registerCss("

    .table-striped > tbody > tr:hover {
         background-color: slategray;
         color: white;
         cursor: pointer;
    }

");
?>
