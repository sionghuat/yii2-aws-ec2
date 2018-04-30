<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Scheduleautooff */

$this->title = 'Set Schedule Auto Off';
$this->params['breadcrumbs'][] = ['label' => 'Set Schedule', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduleautooff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
