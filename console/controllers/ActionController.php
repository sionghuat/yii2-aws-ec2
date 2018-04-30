<?php

namespace console\controllers;

use common\components\AWS;
use Yii;
use yii\console\Controller;
use common\models\Instances;
use yii\behaviors\TimestampBehavior;
use app\models\Scheduleautooff;
use app\models\Scheduleautoon;
use app\models\Savescheduleon;
use app\models\Savescheduleoff;

class ActionController extends Controller {

    public function actionCheckCurrentTime() {

        $timezone = "Asia/Singapore";
        date_default_timezone_set($timezone);
        $date = date('H:i:s');
        echo $date;
        //return $date;
    }

    public function actionIndex() {
        echo "This action is running!";
    }

    public function actionStartInstance() {
        $timezone = "Asia/Singapore";
        date_default_timezone_set($timezone);
        $date = date('H:i:s');
        $scheduleStartTime = scheduleautoon::find()
                ->where(['id' => 1])
                ->one();
        $absolute = strtotime($scheduleStartTime->time);
        $Ids = Scheduleautoon::find()
                ->where(['id' => 1])
                ->one();
//the reprat from database
        $repeat = Scheduleautoon::find()
                ->where(['id' => 1])
                ->one();
        $test = Savescheduleon::find()
                ->where(['date' => date("Y-m-d")])
                ->one();

        if ($test == null) {
            if ($repeat->repeat == "Daily" || $repeat->repeat == date("l")) {
                if (strtotime($date) >= $absolute) {

                    $instanceIds = [$Ids->name];

                    $awsEc2 = Yii::$app->aws->getEc2();
                    echo "Turning On Instance... \n";
                    $awsEc2->startInstances($instanceIds);
                    $awsEc2 = Yii::$app->aws->getEc2();
                    $result = $awsEc2->describeInstances();
                    foreach ($result as $reserve) {
                        foreach ($reserve as $instance) {
                            $existModel = Instances::find()->where(['instance_id' => $instance['InstanceId']]);
                            if ($existModel->exists()) {
                                $instancesModel = $existModel->one();
                            } else {
                                $instancesModel = new Instances();
                            }
                            $instancesModel->ami_launch_index = (isset($instance['AmiLaunchIndex']) ? $instance['AmiLaunchIndex'] : '');
                            $instancesModel->image_id = (isset($instance['ImageId']) ? $instance['ImageId'] : '');
                            $instancesModel->instance_id = (isset($instance['InstanceId']) ? $instance['InstanceId'] : '');
                            $instancesModel->instance_type = (isset($instance['InstanceType']) ? $instance['InstanceType'] : '');
                            $instancesModel->kernel_id = (isset($instance['KernelId']) ? $instance['KernelId'] : '');
                            $instancesModel->key_name = (isset($instance['KeyName']) ? $instance['KeyName'] : '');
                            $instancesModel->launch_time = (isset($instance['LaunchTime']->date) ? $instance['LaunchTime']->date . $instance['LaunchTime']->timezone : '');
                            $instancesModel->monitoring_state = (isset($instance['Monitoring']['State']) ? $instance['Monitoring']['State'] : '');
                            $instancesModel->placement_availability_zone = (isset($instance['Placement']['AvailabilityZone']) ? $instance['Placement']['AvailabilityZone'] : '');
                            $instancesModel->placement_group_name = (isset($instance['Placement']['GroupName']) ? $instance['Placement']['GroupName'] : '');
                            $instancesModel->placement_tenancy = (isset($instance['Placement']['Tenancy']) ? $instance['Placement']['Tenancy'] : '');
                            $instancesModel->private_dns_name = (isset($instance['PrivateDnsName']) ? $instance['PrivateDnsName'] : '');
                            $instancesModel->private_ip_address = (isset($instance['PrivateIpAddress']) ? $instance['PrivateIpAddress'] : '');
                            $instancesModel->public_dns_name = (isset($instance['PublicDnsName']) ? $instance['PublicDnsName'] : '');
                            $instancesModel->public_ip_address = (isset($instance['PublicIpAddress']) ? $instance['PublicIpAddress'] : '');
                            $instancesModel->state_name = (isset($instance['State']['Name']) ? $instance['State']['Name'] : '');
                            $instancesModel->state_transition_reason = (isset($instance['StateTransitionReason']) ? $instance['StateTransitionReason'] : '');
                            $instancesModel->state_reason = (isset($instance['StateReason']['Message']) ? $instance['StateReason']['Message'] : '');
                            $instancesModel->subnet_id = (isset($instance['SubnetId']) ? $instance['SubnetId'] : '');
                            $instancesModel->vpc_id = (isset($instance['VpcId']) ? $instance['VpcId'] : '');
                            $instancesModel->client_token = (isset($instance['ClientToken']) ? $instance['ClientToken'] : '');
                            $instancesModel->network_interfaces = (isset($instance['NetworkInterfaces']) ? json_encode($instance['NetworkInterfaces']) : '');
                            $instancesModel->security_groups = (isset($instance['SecurityGroups']) ? json_encode($instance['SecurityGroups']) : '');
                            $instancesModel->tags = (isset($instance['Tags']) ? json_encode($instance['Tags']) : '');
                            $instancesModel->save();
                            unset($instancesModel);
                            unset($existModel);
                        }
                    }
                    $savescheduleon = new Savescheduleon();
                    $timezone = "Asia/Singapore";
                    $savescheduleon->date = date("Y-m-d");
                    $savescheduleon->save();

                    echo "Turned On Instance on ", $date;
                } else
                    echo 'Not in Service!';
            } else
                echo 'Not in schedule days! ';
        }else
        if ($test->date = date("Y-m-d")) {
            echo "exit";
            exit;
        }
    }

    public function actionStopInstance() {
        $timezone = "Asia/Singapore";
        date_default_timezone_set($timezone);
        $date = date('H:i:s');
        $scheduleStartTime = scheduleautooff::find()
                ->where(['id' => 1])
                ->one();
        $absolute = strtotime($scheduleStartTime->time);
        $Ids = Scheduleautooff::find()
                ->where(['id' => 1])
                ->one();
//the reprat from database
        $repeat = Scheduleautooff::find()
                ->where(['id' => 1])
                ->one();
        $test = Savescheduleoff::find()
                ->where(['date' => date("Y-m-d")])
                ->one();

        if ($test == null) {
            if ($repeat->repeat == "Daily" || $repeat->repeat == date("l")) {
                if (strtotime($date) <= $absolute) {


                    $instanceIds = [$Ids->name];

                    $awsEc2 = Yii::$app->aws->getEc2();
                    echo "Turning On Instance... \n";
                    $awsEc2->startInstances($instanceIds);
                    $awsEc2 = Yii::$app->aws->getEc2();
                    $result = $awsEc2->describeInstances();
                    foreach ($result as $reserve) {
                        foreach ($reserve as $instance) {
                            $existModel = Instances::find()->where(['instance_id' => $instance['InstanceId']]);
                            if ($existModel->exists()) {
                                $instancesModel = $existModel->one();
                            } else {
                                $instancesModel = new Instances();
                            }
                            $instancesModel->ami_launch_index = (isset($instance['AmiLaunchIndex']) ? $instance['AmiLaunchIndex'] : '');
                            $instancesModel->image_id = (isset($instance['ImageId']) ? $instance['ImageId'] : '');
                            $instancesModel->instance_id = (isset($instance['InstanceId']) ? $instance['InstanceId'] : '');
                            $instancesModel->instance_type = (isset($instance['InstanceType']) ? $instance['InstanceType'] : '');
                            $instancesModel->kernel_id = (isset($instance['KernelId']) ? $instance['KernelId'] : '');
                            $instancesModel->key_name = (isset($instance['KeyName']) ? $instance['KeyName'] : '');
                            $instancesModel->launch_time = (isset($instance['LaunchTime']->date) ? $instance['LaunchTime']->date . $instance['LaunchTime']->timezone : '');
                            $instancesModel->monitoring_state = (isset($instance['Monitoring']['State']) ? $instance['Monitoring']['State'] : '');
                            $instancesModel->placement_availability_zone = (isset($instance['Placement']['AvailabilityZone']) ? $instance['Placement']['AvailabilityZone'] : '');
                            $instancesModel->placement_group_name = (isset($instance['Placement']['GroupName']) ? $instance['Placement']['GroupName'] : '');
                            $instancesModel->placement_tenancy = (isset($instance['Placement']['Tenancy']) ? $instance['Placement']['Tenancy'] : '');
                            $instancesModel->private_dns_name = (isset($instance['PrivateDnsName']) ? $instance['PrivateDnsName'] : '');
                            $instancesModel->private_ip_address = (isset($instance['PrivateIpAddress']) ? $instance['PrivateIpAddress'] : '');
                            $instancesModel->public_dns_name = (isset($instance['PublicDnsName']) ? $instance['PublicDnsName'] : '');
                            $instancesModel->public_ip_address = (isset($instance['PublicIpAddress']) ? $instance['PublicIpAddress'] : '');
                            $instancesModel->state_name = (isset($instance['State']['Name']) ? $instance['State']['Name'] : '');
                            $instancesModel->state_transition_reason = (isset($instance['StateTransitionReason']) ? $instance['StateTransitionReason'] : '');
                            $instancesModel->state_reason = (isset($instance['StateReason']['Message']) ? $instance['StateReason']['Message'] : '');
                            $instancesModel->subnet_id = (isset($instance['SubnetId']) ? $instance['SubnetId'] : '');
                            $instancesModel->vpc_id = (isset($instance['VpcId']) ? $instance['VpcId'] : '');
                            $instancesModel->client_token = (isset($instance['ClientToken']) ? $instance['ClientToken'] : '');
                            $instancesModel->network_interfaces = (isset($instance['NetworkInterfaces']) ? json_encode($instance['NetworkInterfaces']) : '');
                            $instancesModel->security_groups = (isset($instance['SecurityGroups']) ? json_encode($instance['SecurityGroups']) : '');
                            $instancesModel->tags = (isset($instance['Tags']) ? json_encode($instance['Tags']) : '');
                            $instancesModel->save();
                            unset($instancesModel);
                            unset($existModel);
                        }
                    }
                    $savescheduleoff = new Savescheduleoff();
                    $timezone = "Asia/Singapore";
                    $savescheduleoff->date = date("Y-m-d");
                    $savescheduleoff->save();

                    echo "Turned On Instance on ", $date;
                } else
                    echo 'Not in Service!';
            } else
                echo 'Not in schedule days! ';
        }else
        if ($test->date = date("Y-m-d")) {
            echo "exit";
            exit;
        }
    }
}