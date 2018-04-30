<?php

use yii\db\Migration;

/**
 * Class m180329_035815_set_scheduleAutoOn
 */
class m180329_035815_set_scheduleAutoOn extends Migration {

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
//        echo "m180329_035815_set_scheduleAutoOn cannot be reverted.\n";
//
//        return false;
//    }
    // Use up()/down() to run migration code without a transaction.
    public function up() {
        $this->createtable('scheduleautoon', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'time' => $this->time(),
            'repeat' => $this->string(64),
        ]);
    }

    public function down() {
        $this->dropTable('scheduleautoon');
    }

}
