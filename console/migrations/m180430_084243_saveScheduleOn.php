<?php

use yii\db\Migration;

/**
 * Class m180430_084243_saveScheduleOn
 */
class m180430_084243_saveScheduleOn extends Migration {

    /**
     * {@inheritdoc}
     */
//public function safeUp()
//{
//
//}
//
///**
//* {@inheritdoc}
//*/
//public function safeDown()
//{
//echo "m180430_084243_saveScheduleOn cannot be reverted.\n";
//
//return false;
//}
// Use up()/down() to run migration code without a transaction.
    public function up() {
        $this->createtable('savescheduleon', [
            'id' => $this->primaryKey(),
            'date' => $this->date(),
        ]);
    }

    public function down() {
        $this->dropTable('savescheduleon');
    }

}
