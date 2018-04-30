<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\spinner\Spinner;

$name = '';
if (!empty($model->tags)) {
    $tags = json_decode($model->tags, 1);
}
if (isset($tags)) {
    foreach ($tags as $key => $val) {
        if ($val['Key'] == 'Name') {
            $name = $val['Value'];
        }
    }
}
$this->title = $name;
$this->params['breadcrumbs'][] = ['label' => 'Instances', 'url' => ['index']];
?>
<style>
    #button-group > a {
        margin: 2px; }
    #spinner {
        display: none;
        height: 35px;
    }
</style>
<script>
    function doInstance(action) {
    var datas = {ids:[<?php echo Yii::$app->request->get('id') ?>], _csrf: yii.getCsrfToken()};
    switch (action){
    case 'on':
            swal({
            title: "Are you sure want to START?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
            })
            .then((confirm) => {
            if (confirm == true)
            {
            $('#spinner').show();
            $.post("turn-on", datas)
                    .done(function(data)
                    {
                    $('#spinner').hide(); ;
                    });
            swal("Success!", {
            icon: "success",
            });
            }
            });
    break;
    case 'off':
            swal({
            title: "Are you sure want to STOP?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
            })
            .then((confirm) => {
            if (confirm == true)
            {
            $('#spinner').show();
            $.post("turn-off", datas)
                    .done(function(data)
                    {
                    $('#spinner').hide(); ;
                    });
            swal("Success!", {
            icon: "success",
            });
            }
            });
    break;
    case 'reboot':
            swal({
            title: "Are you sure want to Reboot?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
            })
            .then((confirm) => {
            if (confirm == true)
            {
            $('#spinner').show();
            $.post("reboot", datas)
                    .done(function(data)
                    {
                    $('#spinner').hide(); ;
                    });
            swal("Success!", {
            icon: "success",
            });
            }
            });
    break;
    }
    }
</script>
<div class="page-header clearfix">
    <div class="pull-left">
        <h1><?php echo $this->title; ?></h1>        
    </div>
    <div id="button-group" class="pull-right">
        <?php
        echo Html::a('Start', '#', [
            'class' => 'btn btn-sm btn-success',
            'onclick' => 'js:doInstance("on");'
        ]);
        echo Html::a('Stop', '#', [
            'class' => 'btn btn-sm btn-danger',
            'onclick' => 'js:doInstance("off");'
        ]);
        echo Html::a('Reboot', '#', [
            'class' => 'btn btn-sm btn-warning',
            'onclick' => 'js:doInstance("reboot");'
        ]);
        ?>
    </div>
</div>
<div class="row">
    <div id="spinner">
        <?=
        Spinner::widget([
            'preset' => Spinner::LARGE,
        ])
        ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-12">
        <?php
        echo DetailView::widget([
            'model' => $model,
            'condensed' => true,
            'hover' => true,
            'mode' => DetailView::MODE_VIEW,
            'attributes' => [
                'instance_id',
                'ami_launch_index',
                'image_id',
                'instance_type',
                'kernel_id',
                'key_name',
                'launch_time',
                'monitoring_state',
                'placement_availability_zone',
                'placement_group_name',
                'placement_tenancy',
                'private_dns_name',
                'private_ip_address',
                'public_dns_name',
                'public_ip_address',
                'state_name',
                'state_transition_reason',
                'subnet_id',
                'vpc_id',
                'client_token',
                'network_interfaces',
                'root_device_name',
                'root_device_type',
                'security_groups',
                'tags',
                'state_reason',
                'description',
                'remark',
//                'created_at:dateTime',
                'updated_at:dateTime',
            ]
        ]);
        ?>               
    </div>
</div>