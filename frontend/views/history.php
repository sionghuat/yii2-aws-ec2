<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\History */
/* @var $form ActiveForm */
?>
<div class="history">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'timeStamp') ?>
    <?= $form->field($model, 'users') ?>
    <?= $form->field($model, 'status') ?>
    <?= $form->field($model, 'instances') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- history -->
