<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduleautoonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Set Schedule(Auto On)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduleautoon-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Set Schedule Auto On', ['create'], ['class' => 'btn btn-success']) ?>
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
    <frameset id="myframeset" rows="12%,86%,*" frameborder=0 noresize framespacing=0>
        <frame frameborder=0 name="title" src="@frontend/views/scheduleautooff/index.php" scrolling = "no" noresize marginwidth="0" marginheight=0>
    </frameset>
</div>

