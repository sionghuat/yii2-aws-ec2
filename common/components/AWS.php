<?php

namespace common\components;

use common\components\AWSEc2;

use Aws\Sdk;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class AWS extends Component {
    
    /**
     * @var
     */
    public $key;
    public $secret;
    public $region;
    public $version;
    
    public $ec2;

    private $_config;
    private $_sdk = null;
    
    private $instances = [];

    /**
     * Init Component
     */
    public function init() {
        if (!$this->key) {
            throw new InvalidConfigException("Key can't be empty!");
        }
        if (!$this->secret) {
            throw new InvalidConfigException("Secret can't be empty!");
        }
        if (!$this->region) {
            throw new InvalidConfigException("Region can't be empty!");
        }
        $this->_config = [
            'version' => $this->version,
            'region' => $this->region,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret,
            ],
        ];
    }

    /**
     * @return \Aws\Sdk
     */
    public function getSdk() {
        if ($this->_sdk === null) {
            $this->_sdk = new Sdk($this->_config);
        }
        return $this->_sdk;
    }
    
    /**
     * @return \common\components\AWSEc2
     */
    public function getEc2() {
        if (empty($this->instances['ec2'])) {
            $this->instances['ec2'] = new \common\components\AWSEc2($this);
        }

        return $this->instances['ec2'];
    }

}
