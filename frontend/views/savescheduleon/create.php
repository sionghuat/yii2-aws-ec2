<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Savescheduleon */

$this->title = 'Create Savescheduleon';
$this->params['breadcrumbs'][] = ['label' => 'Savescheduleons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="savescheduleon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
