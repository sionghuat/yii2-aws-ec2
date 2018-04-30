<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username'); ?>
<?= $form->field($model, 'password'); ?>

<?= Html::submitButton('Next', ['class' => 'btn btn-success']); ?>