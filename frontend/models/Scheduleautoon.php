<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scheduleautoon".
 *
 * @property int $id
 * @property string $name
 * @property string $time
 * @property string $repeat
 */
class Scheduleautoon extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'scheduleautoon';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['time'], 'safe'],
            [['name', 'repeat'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name(Instance ID)',
            'time' => 'Time(24 Hour Format)',
            'repeat' => 'Repeat',
        ];
    }

}
