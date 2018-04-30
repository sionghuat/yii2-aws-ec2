<?php

use yii\db\Migration;

/**
 * Class m180314_075130_add_history
 */
class m180314_075130_add_history extends Migration {

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
//        echo "m180314_075130_add_history cannot be reverted.\n";
//
//        return false;
//    }
    // Use up()/down() to run migration code without a transaction.
    public function up() {
        $this->createtable('history', [
            'id' => $this->primaryKey(),
            'timeStamp' => $this->string(64),
            'users' => $this->string(64),
            'status' => $this->string(64),
            'instances' => $this->string(64),
        ]);
    }

    public function down() {
        $this->dropTable('history');
    }

}
