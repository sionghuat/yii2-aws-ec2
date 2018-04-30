<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "savescheduleon".
 *
 * @property int $id
 * @property string $date
 */
class Savescheduleon extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'savescheduleon';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'date' => 'Date',
        ];
    }

}
