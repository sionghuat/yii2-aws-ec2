<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Scheduleautoon */
/* @var $form ActiveForm */
?>
<div class="scheduleonauto">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'time') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'repeat') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- scheduleonauto -->
