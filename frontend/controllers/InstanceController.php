<?php

namespace frontend\controllers;

use common\components\AWS;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\Instances;
use app\models\History;
use frontend\models\HistorySearch;
use app\models\User;
use frontend\models\UserSearch;
use yii\behaviors\TimestampBehavior;
use app\models\Test;

class InstanceController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $instancesModel = new Instances();

        if (Yii::$app->request->post('hasEditable')) {
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = [];
            $post['Instances'] = current(Yii::$app->request->post('Instances'));
            if ($model->load($post)) {
                $model->save();
                return ['output' => '', 'message' => ''];
            } else {
                return ['output' => '', 'message' => 'Error, failed to save.'];
            }
        }

        if (!$instancesModel->find()->exists()) {
            $this->updateInstancesLiveData();
        }
        $statusFilter = [
            '' => 'All', 'running' => 'Running', 'stopped' => 'Stopped', 'pending' => 'Pending', 'stopping' => 'Stopping',
            'shutting-down' => 'Shutting Down', 'terminated' => 'Terminated'
        ];
        $dataProvider = $instancesModel->dataProvider();
        
        return $this->render('index', [
                    'model' => $instancesModel,
                    'dataProvider' => $dataProvider,
                    'statusFilter' => $statusFilter,
        ]);
    }

    public function actionSyncInstance() {
        $this->updateInstancesLiveData();
        $this->redirect('index');
    }

    /**
     * Displays a single instance model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionTurnOn() {
        if (Yii::$app->request->isAjax) {
            $instanceIds = [];
            $instanceName = [];
            $ids = Yii::$app->request->post('ids');
            $awsEc2 = Yii::$app->aws->getEc2();
            if ($ids) {
                foreach ($ids as $instance) {
                    $instanceModel = Instances::findOne($instance);
                    $instanceIds[] = $instanceModel->instance_id;
                    $instanceName[] = $instanceModel->tags;

                    $json = $instanceModel->tags;
                    $tags = json_decode($json, true);
                    $name = '';

                    foreach ($tags as $key => $val) {
                        if ($val['Key'] == 'Name') {
                            $name = $val['Value'];
                        }
                    }
                }
            }
            $state = instances::find()
                    ->where(['id' => $ids])
                    ->one();
            if ($state->state_name == 'running') {
                Yii::$app->session->setFlash('error', 'The instance are running, cannot START again!');
            } else {
                $result = $awsEc2->startInstances($instanceIds);
                \Yii::$app->getSession()->setFlash('success', 'Instances are turning on, please wait awhile and click on instance update button to verify the status.');
                $user = User::findOne(Yii::$app->user->id);
                $history = new History();

                $timezone = "Asia/Singapore";
                date_default_timezone_set($timezone);


                $history->timeStamp = date('Y-m-d H:i:s');
                $history->users = $user->username;
                $history->status = 'start';
                $history->instances = $name;
                $history->save();
            }
            $this->redirect('index');
        }
    }

    public function actionTurnOff() {
        if (Yii::$app->request->isAjax) {
            $instanceIds = [];
            $instanceName = [];
            $ids = Yii::$app->request->post('ids');
            $awsEc2 = Yii::$app->aws->getEc2();
            if ($ids) {
                foreach ($ids as $instance) {
                    $instanceModel = Instances::findOne($instance);
                    $instanceIds[] = $instanceModel->instance_id;
                    $instanceName[] = $instanceModel->tags;

                    $json = $instanceModel->tags;
                    $tags = json_decode($json, true);
                    $name = '';


                    foreach ($tags as $key => $val) {
                        if ($val['Key'] == 'Name') {
                            $name = $val['Value'];
                        }
                    }
                }
                $state = instances::find()
                        ->where(['id' => $ids])
                        ->one();

                if ($state->state_name == 'stopped') {
                    Yii::$app->session->setFlash('error', 'The instance stopped, cannot STOP again!');
                } else {
                    $result = $awsEc2->stopInstances($instanceIds);
                    \Yii::$app->getSession()->setFlash('success', 'Instances are turning off, please wait awhile and click on instance update button to verify the status.');

                    $user = User::findOne(Yii::$app->user->id);

                    $history = new History();

                    $timezone = "Asia/Singapore";
                    date_default_timezone_set($timezone);

                    $history->timeStamp = date('Y-m-d H:i:s');
                    $history->users = $user->username;
                    $history->status = 'stopped';
                    $history->instances = $name;
                $history->save();
                }

                $this->redirect('index');
            }
        }
    }

    public function actionReboot() {
        if (Yii::$app->request->isAjax) {
            $instanceIds = [];
            $instanceName = [];
            $ids = Yii::$app->request->post('ids');
            $awsEc2 = Yii::$app->aws->getEc2();
            if ($ids) {
                foreach ($ids as $instance) {
                    $instanceModel = Instances::findOne($instance);
                    $instanceIds[] = $instanceModel->instance_id;
                    $instanceName[] = $instanceModel->tags;

                    $json = $instanceModel->tags;
                    $tags = json_decode($json, true);
                    $name = '';


                    foreach ($tags as $key => $val) {
                        if ($val['Key'] == 'Name') {
                            $name = $val['Value'];
                        }
                    }
                }
                $result = $awsEc2->rebootInstances($instanceIds);
                \Yii::$app->getSession()->setFlash('success', 'Instances are rebooting, please wait awhile and click on instance update button to verify the status.');

                $user = User::findOne(Yii::$app->user->id);

                $history = new History();

                $timezone = "Asia/Singapore";
                date_default_timezone_set($timezone);

                $history->timeStamp = date('Y-m-d H:i:s');
                $history->users = $user->username;
                $history->status = 'reboot';
                $history->instances = $name;
                $history->save();

                $this->redirect('index');
            }
        }
    }

    /**
     * Finds the currencies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return instance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Instances::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function updateInstancesLiveData() {
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
    }

}
