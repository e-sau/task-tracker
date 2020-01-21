<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'templates' => $templates
    ]) ?>

</div>

<?php

$this->registerJs("

    $('#task-template_id').on('change', function (e) {
        templateId = $(this).val();
        if (templateId) {
            $.post('get-template', {'template_id': templateId})
                .done(response => {
                    if (response.error) {
                        console.log(response.error);
                    } else {
                        $('#task-title').val(response.title);
                        $('#task-status').val(response.status);
                        $('#task-description').val(response.description);
                        $('#task-priority_id').val(response.priority_id);
                    }
                });
        }
    });

");
