<?php

use yii\db\Migration;

/**
 * Class m180329_061213_set_scheduleAutoOff
 */
class m180329_061213_set_scheduleAutoOff extends Migration {

    /**
     * {@inheritdoc}
     */
//    public function safeUp()
//    {
//
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function safeDown()
//    {
//        echo "m180329_061213_set_scheduleAutoOff cannot be reverted.\n";
//
//        return false;
//    }
    // Use up()/down() to run migration code without a transaction.
    public function up() {
        $this->createtable('scheduleautooff', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'time' => $this->time(),
            'repeat' => $this->string(64),
        ]);
    }

    public function down() {
        $this->dropTable('scheduleautooff');
    }

}
