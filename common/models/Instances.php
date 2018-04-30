<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "instances".
 *
 * @property int $id
 * @property int $ami_launch_index
 * @property string $image_id
 * @property string $instance_id
 * @property string $instance_type
 * @property string $kernel_id
 * @property string $key_name
 * @property string $launch_time
 * @property string $monitoring_state
 * @property string $placement_availability_zone
 * @property string $placement_group_name
 * @property string $placement_tenancy
 * @property string $private_dns_name
 * @property string $private_ip_address
 * @property string $public_dns_name
 * @property string $public_ip_address
 * @property string $state_name
 * @property string $state_transition_reason
 * @property string $subnet_id
 * @property string $vpc_id
 * @property string $client_token
 * @property string $network_interfaces
 * @property string $root_device_name
 * @property string $root_device_type
 * @property string $security_groups
 * @property string $tags
 * @property string $state_reason
 * @property string $description
 * @property string $remark
 * @property int $created_at
 * @property int $updated_at
 */
class Instances extends \yii\db\ActiveRecord {

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'instances';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ami_launch_index', 'created_at', 'updated_at'], 'integer'],
            [['network_interfaces', 'security_groups', 'tags', 'description', 'remark'], 'string'],
            [['image_id', 'instance_id', 'kernel_id', 'subnet_id', 'vpc_id', 'client_token'], 'string', 'max' => 23],
            [['instance_type', 'key_name', 'launch_time', 'placement_availability_zone', 'placement_group_name', 'placement_tenancy', 'private_dns_name', 'public_dns_name', 'state_transition_reason', 'root_device_name', 'state_reason'], 'string', 'max' => 255],
            [['private_ip_address', 'public_ip_address'], 'string', 'max' => 16],
            [['state_name', 'root_device_type', 'monitoring_state'], 'string', 'max' => 127],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ami_launch_index' => 'Ami Launch Index',
            'image_id' => 'Image ID',
            'instance_id' => 'Instance ID',
            'instance_type' => 'Instance Type',
            'kernel_id' => 'Kernel ID',
            'key_name' => 'Key Name',
            'launch_time' => 'Launch Time',
            'monitoring_state' => 'Monitoring State',
            'placement_availability_zone' => 'Placement Availability Zone',
            'placement_group_name' => 'Placement Group Name',
            'placement_tenancy' => 'Placement Tenancy',
            'private_dns_name' => 'Private Dns Name',
            'private_ip_address' => 'Private Ip Address',
            'public_dns_name' => 'Public Dns Name',
            'public_ip_address' => 'Public Ip Address',
            'state_name' => 'State Name',
            'state_transition_reason' => 'State Transition Reason',
            'subnet_id' => 'Subnet ID',
            'vpc_id' => 'Vpc ID',
            'client_token' => 'Client Token',
            'network_interfaces' => 'Network Interfaces',
            'root_device_name' => 'Root Device Name',
            'root_device_type' => 'Root Device Type',
            'security_groups' => 'Security Groups',
            'tags' => 'Name',
            'state_reason' => 'State Reason',
            'description' => 'Description',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function dataProvider() {
        $query = static::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort' => [
                'attributes' => ['id']
            ]
        ]);

        if (Yii::$app->getRequest()->getQueryParam('Instances') && $this->load(Yii::$app->getRequest()->getQueryParams())) {
            $searchParams = Yii::$app->getRequest()->getQueryParam('Instances');
            foreach ($searchParams as $param => $value) {
                if ($param == 'state_name') {
                    $query->andFilterWhere([$param => $value]);
                } else {
                    $query->andFilterWhere(['like', $param, $value]);
                }
            }
        }

        return $dataProvider;
    }

}
