<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "savescheduleoff".
 *
 * @property int $id
 * @property string $date
 */
class Savescheduleoff extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'savescheduleoff';
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
