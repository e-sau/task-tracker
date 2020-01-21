<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'creator_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'priority_id')->label('Priority')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Priority::find()
            ->where(['type' => \common\models\Priority::TYPE_PROJECT])
            ->all(), 'id', 'title'),
        ['prompt' => 'Choose priority']
    ) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusTitle()) ?>

    <?= $form->field($model, 'parent_project_id')->label('Parent Project')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Project::find()->all(),
                'id',
                function($element) {
                    return "[{$element->id}] {$element->title}";
                }),
            ['prompt' => 'Choose project']
    ) ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
