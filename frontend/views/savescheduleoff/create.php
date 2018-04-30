<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Savescheduleoff */

$this->title = 'Create Savescheduleoff';
$this->params['breadcrumbs'][] = ['label' => 'Savescheduleoffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="savescheduleoff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
