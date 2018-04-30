<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $permissons
 * @property string $created_at
 * @property string $update_at
 */
class Users extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'email', 'password', 'permissons', 'created_at', 'update_at'], 'required'],
            [['id', 'permissons'], 'integer'],
            [['email', 'password', 'created_at', 'update_at'], 'string', 'max' => 64],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'permissons' => 'Permissons',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }

}
