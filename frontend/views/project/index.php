<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
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
//            'creator_id',
            'title',
//            'description:ntext',
//            'priority_id',
            [
                'attribute' => 'creator.username',
                'label' => 'Creator'
            ],
            [
                'attribute' => 'priority.title',
                'label' => 'Priority'
            ],
            [
                'attribute' => 'status',
                'value' => function(\common\models\Project $model) {
                    return $model->getStatusTitle()[$model->status];
                }
            ],
            //'parent_project_id',
            //'created_at',
            //'updated_at',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<?= \frontend\widgets\chat\Chat::widget() ?>
<?php
$this->registerJs("

    $('td').click(function (e) {
        var id = $(this).closest('tr').data('id');
        if(id && e.target == this)
            location.href = '" . \yii\helpers\Url::to(['project/view']) . "?id=' + id;
    });

");

$this->registerCss("

    .table-striped > tbody > tr:hover {
         background-color: slategray;
         color: white;
         cursor: pointer;
    }

");
