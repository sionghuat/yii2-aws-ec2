<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property string $timeStamp
 * @property string $users
 * @property string $status
 * @property string $instances
 */
class History extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['timeStamp', 'users', 'status', 'instances'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'timeStamp' => 'Time Stamp',
            'users' => 'Users',
            'status' => 'Status',
            'instances' => 'Instances',
        ];
    }

}
