<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SavescheduleonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Savescheduleons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="savescheduleon-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Savescheduleon', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
