<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form ActiveForm */
?>
<div class="schedule">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'startTime') ?>
    <?= $form->field($model, 'endTime') ?>
    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- schedule -->
