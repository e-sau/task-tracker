<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var $templates array */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'template_id')->dropDownList(
        $templates,
        ['prompt' => 'No template']
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusTitle()) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php //$form->field($model, 'creator_id')->textInput() ?>

    <?= $form->field($model, 'performer_id')->label('Performer')->dropDownList(
        \common\models\User::find()->select(['username', 'id'])->indexBy('id')->column(),
        ['prompt' => 'Choose performer']
    ) ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'priority_id')->label('Priority')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Priority::find()
            ->where(['type' => \common\models\Priority::TYPE_TASK])
            ->all(), 'id', 'title'),
        ['prompt' => 'Choose priority']
    ) ?>

    <?= $form->field($model, 'project_id')->label('Project')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Project::find()
            ->all(), 'id', 'title'),
        ['prompt' => 'Choose project']
    ) ?>

    <?= $form->field($model, 'is_template')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
