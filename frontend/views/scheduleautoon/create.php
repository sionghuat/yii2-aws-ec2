<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Scheduleautoon */

$this->title = 'Set Schedule Auto On';
$this->params['breadcrumbs'][] = ['label' => 'Set Schedule', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduleautoon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
