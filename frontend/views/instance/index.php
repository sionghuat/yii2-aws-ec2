<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\spinner\Spinner;

$this->title = 'Instances';
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
    jQuery("#sync-btn").click(function(){
        jQuery("#sync-btn-name").hide();
        jQuery("#sync-loading").show();
    });
JS;
$this->registerJs($script, \yii\web\VIEW::POS_END);
?>
<script>
    function doInstance(action) {
        var keys = jQuery('#instance-list').yiiGridView('getSelectedRows');
        var datas = {ids:keys,_csrf: yii.getCsrfToken()};
        switch(action){
            case 'on':
                $('#spinner').show();
                $.post( "turn-on", datas)
                    .done(function( data ) {
                        $('#spinner').hide();;
                    });
                break;
            case 'off':
                $('#spinner').show();
                $.post( "turn-off", datas)
                    .done(function( data ) {
                        $('#spinner').hide();;
                    });
                break;
            case 'reboot':
                $('#spinner').show();
                $.post( "reboot", datas)
                    .done(function( data ) {
                        $('#spinner').hide();;
                    });
                break;
        }
    }
</script>
<style>
    #sync-loading { display: none; }
    .btn-group > .btn {
        margin: 2px;
    }
    #spinner {
        display: none;
        height: 35px;
    }
</style>

<div class="page-header clearfix">
    <div class="pull-right">
        <a id="sync-btn" href="<?php echo \Yii::$app->urlManager->createUrl(['/instance/sync-instance']); ?>" class="btn btn-sm btn-warning">
            <span id="sync-loading">
                <?php echo Spinner::widget(['preset' => 'tiny', 'align' => 'left', 'caption' => 'Loading &hellip;']); ?>
            </span>
            <span id="sync-btn-name">
                <i class="ace-icon fa fa-refresh"></i><?php echo 'Trigger Instance Update'; ?>
            </span>
        </a>
    </div>
</div>
<div class="row">
    <div id="spinner">
        <?= Spinner::widget([
            'preset' => Spinner::LARGE,
        ])?>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12">
        <?php
        echo GridView::widget([
            'id' => 'instance-list',
            'dataProvider' => $dataProvider,
            'filterModel' => $model,
            'export' => false,
            'pjax' => true,
            'hover' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
            ],
//            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'toolbar' =>  [
                ['content' =>
                    Html::button('On', ['type' => 'button', 'title' => 'Turn On Instance', 'class' => 'btn btn-success', 'onclick' => 'js:doInstance("on");']) . '' .
                    Html::button('Off', ['type' => 'button', 'title' => 'Turn Off Instance', 'class' => 'btn btn-danger', 'onclick' => 'js:doInstance("off");']) . '' .
                    Html::button('Restart', ['type' => 'button', 'title' => 'Reboot Instance', 'class' => 'btn btn-warning', 'onclick' => 'js:doInstance("reboot");'])],
                '{toggleData}',
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'EC2 Instances',
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\DataColumn',
                    'attribute' => 'instance_id',
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'attribute' => 'tags',
                    'value' => function ($model) {
                        $name='';
                        if(!empty($model['tags'])) {
                            $tags = json_decode($model['tags'],1);
                        }
                        if(isset($tags)) {
                            foreach($tags as $key => $val) {
                                if($val['Key'] == 'Name') {
                                    $name = $val['Value'];
                                }
                            }
                        }
                        return $name;
                    },
                ],
//                [
//                    'class' => 'yii\grid\DataColumn',
//                    'attribute' => 'instance_type',
//                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'description',
                    'editableOptions' =>  function ($model, $key, $index) {
                        return [
                            'header' => 'description',
                            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                            'size' => 'md',
                        ];
                    }
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'attribute' => 'private_ip_address',
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'attribute' => 'public_ip_address',
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'remark',
                    'editableOptions' =>  function ($model, $key, $index) {
                        return [
                            'header' => 'remark',
                            'size' => 'md',
                        ];
                    }
                ],
                [
                    'class' => 'kartik\grid\DataColumn',
                    'attribute' => 'state_name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $statusFilter,
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model['state_name'] == 'running') {
                            return Html::tag('span', 'Running', ['class' => 'label label-success arrowed']);
                        } else if ($model['state_name'] == 'stopped') {
                            return Html::tag('span', 'Stopped', ['class' => 'label label-danger arrowed-in']);
                        } else if ($model['state_name'] == 'pending') {
                            return Html::tag('span', 'Pending', ['class' => 'label label-primary arrowed-in']);
                        } else if ($model['state_name'] == 'stopping') {
                            return Html::tag('span', 'Stopping', ['class' => 'label label-warning arrowed-in']);
                        } else if ($model['state_name'] == 'shutting-down') {
                            return Html::tag('span', 'Shutting Down', ['class' => 'label label-warning arrowed-in']);
                        } else if ($model['state_name'] == 'terminated') {
                            return Html::tag('span', 'Terminated', ['class' => 'label label-warning arrowed-in']);
                        }
                        return $model['state_name'];
                    },
                ],
//                [
//                    'class' => 'kartik\grid\ExpandRowColumn',
//                    'expandTitle' => 'Network Interfaces',
//                    'width' => '50px',
//                    'value' => function ($model, $key, $index, $column) {
//                        return GridView::ROW_COLLAPSED;
//                    },
//                    'detail' => function ($model, $key, $index, $column) {
//                        return Yii::$app->controller->renderPartial('_network-details', ['model' => $model]);
//                    },
//                    'headerOptions' => ['class' => 'kartik-sheet-style'],
//                    'expandOneOnly' => true
//                ],
//                [
//                    'class' => 'kartik\grid\ExpandRowColumn',
//                    'expandTitle' => 'Network Interfaces',
//                    'width' => '50px',
//                    'value' => function ($model, $key, $index, $column) {
//                        return GridView::ROW_COLLAPSED;
//                    },
//                    'detail' => function ($model, $key, $index, $column) {
//                        return Yii::$app->controller->renderPartial('_security-details', ['model' => $model]);
//                    },
//                    'headerOptions' => ['class' => 'kartik-sheet-style'],
//                    'expandOneOnly' => true
//                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $url = \Yii::$app->urlManager->createUrl(['/instance/view', 'id' => $model['id']]);
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'View', 'data-pjax' => '0']);
                        },
                    ],
                ],
                [
                    'class' => 'kartik\grid\CheckboxColumn',
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                ],
            ],
        ]);
        ?>
    </div>
</div>