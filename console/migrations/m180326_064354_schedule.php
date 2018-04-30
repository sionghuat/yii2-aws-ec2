<?php

use yii\db\Migration;

/**
 * Class m180326_064354_schedule
 */
class m180326_064354_schedule extends Migration {

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
//        echo "m180326_064354_schedule cannot be reverted.\n";
//
//        return false;
//    }
    // Use up()/down() to run migration code without a transaction.
    public function up() {
//        $this->createtable('schedule',[
//            'id' => $this->primaryKey(),
//            'name' => $this->string(64),
//            'startTime' => $this->dateTime(),
//            'endTime' => $this->dateTime(),
//             ]);
    }

    public function down() {
//        $this->dropTable('schedule');
    }

}
