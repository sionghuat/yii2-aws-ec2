<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Scheduleautoon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scheduleautoon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'name')->dropDownList(
            [
                'i-43b2ae24' => 'ec2-outsource',
                'i-07eda27944ad6c9d7' => 'StagingG2G',
                'i-065319dcddd2a0d3a' => 'ec2-outsource-OLD',
                'i-2856b278' => 'vpc-testaccount-oldserver',
                'i-51f9c83f' => 'ec2-testjoomla',
                'i-0b36bda937766cce1' => 'ec2-testapi-64bit',
                'i-08e46b9957f9690b6' => 'vpc-testvpn',
                'i-47ffea97' => 'vpc-testpipwave',
                'i-3862e7c5' => 'vpc-testplaynow-php54',
                'i-87f8c9e9' => 'ec2-testcrew',
                'i-022a648d429a91ea4' => 'vpc-testjoomla~new',
                'i-57856807' => 'vpc-testg2gcrew',
                'i-05384d47e63cbd9ed' => 'testingserver',
                'i-0a508bf2ea8fd8e49' => 'vpc-testg2gcrew-php56',
                'i-07a4ee304b018a39a' => 'vpc-WindowServer',
                'i-fcf57865' => 'vpc-testmgc',
                'i-d3659d54' => 'vpc-testg2g',
                'i-14e5f6c4' => 'vpc-testogc-oldogc',
                'i-23b84aba' => 'vpc-testwww-64bit-php56',
                'i-66a71a9c' => 'vpc-staging-g2g',
                'i-09a754640612d982d' => 'ec2-ogc-staging',
                'i-a2fb70c4' => 'vpc-testg2g-20160411',
                'i-033721a345cebf2d8' => 'vpc-testaccount-shassobiz	',
                'i-41d29420' => 'ec2-testsolara',
                'i-0822e053cba5e9809' => 'vpc-testcrew-64bit',
                'i-058e9186bb3297197' => 'vpc-testelk-bitnami',
                'i-0be93aab522f2b890' => 'vpc-testelk',
                'i-0138a9c7972b6f155' => 'vpc-testwww-testing',
    ])
    ?>

    <?php
    echo '<label>Time(24 Hour Format)</label>';
    echo TimePicker::widget([
        'model' => $model,
        'attribute' => 'time',
        'name' => 'startTime',
        'pluginOptions' => [
            'showSeconds' => true,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 5,
        ]
    ]);
    ?><br>

    <?=
    $form->field($model, 'repeat')->dropDownList(
            [
                'Daily' => 'Daily',
                'Monday' => 'Monday',
                'Tuesday' => 'Tuesday',
                'Wednesday' => 'Wednesday',
                'Thursday' => 'Thursday',
                'Friday' => 'Friday',
                'Saturday' => 'Saturday',
                'Sunday' => 'Sunday',
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
