<?php

namespace common\components;

use Yii;

//https://docs.aws.amazon.com/aws-sdk-php/v3/api/namespace-Aws.Ec2.html
//https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-ec2-2016-11-15.html

class AWSEc2 {

    /**
     * @var \common\components\AWS
     */
    private $_aws;

    /**
     * @var \Aws\Ec2\Ec2Client
     */
    private $_instance;

    public function __construct(\common\components\AWS $aws = null, $config = false) {
        if (!isset($aws)) {
            $aws = Yii::$app->aws;
            if ($config === false) {
                $config = $aws->ec2;
            }
        }
        if ($config === false) {
            $config = [];
        }
        $this->_aws = $aws;
        $extra_args = [];
        if (!empty($config['region'])) {
            $extra_args['region'] = $config['region'];
        }
        if (!empty(Yii::$app->params['PROXY_HOST'])) {
            $extra_args['http'] = [
                'proxy' => Yii::$app->params['PROXY_HOST'] . ':' . Yii::$app->params['PROXY_PORT'],
            ];
        }
        if (!empty($config['key'])) {
            $extra_args['credentials']['key'] = $config['key'];
        }
        if (!empty($config['secret'])) {
            $extra_args['credentials']['secret'] = $config['secret'];
        }
        $this->_instance = $aws->getSdk()->createEc2($extra_args);
    }

    /**
     * @return \Aws\ApiGateway\ApiGatewayClient the instance
     */
    public function getInstance() {
        return $this->_instance;
    }

    /**
     * @inheritdoc
     */
    public function describeInstances($instanceIds = []) {
        $instance = [];
        $reserveIndex = 0;
        if (!$this->_instance) {
            return false;
        }
        $params = (!empty($instanceIds)) ? ['InstanceIds' => $instanceIds] : [];
        $returns = $this->_instance->DescribeInstances($params);
        foreach ($returns as $reserves) {
            foreach ($reserves as $index => $reserve) {
                $reserveIndex = $index;
                if (isset($reserve['Instances'])) {
                    foreach ($reserve['Instances'] as $instances) {
                        $instance[$reserveIndex][] = $instances;
                    }
                }
            }
        }
        return $instance;
    }

    /**
     * @inheritdoc
     */
    public function startInstances($instanceIds) {
        if (!$this->_instance) {
            return false;
        }
        $returns = $this->_instance->StartInstances(['InstanceIds' => $instanceIds]);

        return $returns;
    }

    /**
     * @inheritdoc
     */
    public function stopInstances($instanceIds) {
        if (!$this->_instance) {
            return false;
        }
        $returns = $this->_instance->StopInstances(['InstanceIds' => $instanceIds]);

        return $returns;
    }

    /**
     * @inheritdoc
     */
    public function rebootInstances($instanceIds) {
        if (!$this->_instance) {
            return false;
        }
        $returns = $this->_instance->RebootInstances(['InstanceIds' => $instanceIds]);

        return $returns;
    }

}
