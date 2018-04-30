<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduleautooffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Set Schedule(Auto Off)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduleautooff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Set Schedule Auto Off', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'name',
            'time',
            'repeat',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
