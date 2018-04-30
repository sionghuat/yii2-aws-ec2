<?php

use yii\db\Migration;

class m180301_102639_add_instances_table extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%instances}}', [
            'id' => $this->primaryKey(),
            'ami_launch_index' => $this->integer(12),
            'image_id' => $this->string(23),
            'instance_id' => $this->string(23),
            'instance_type' => $this->string(255),
            'kernel_id' => $this->string(23),
            'key_name' => $this->string(255),
            'launch_time' => $this->string(255),
            'monitoring_state' => $this->string(127),
            'placement_availability_zone' => $this->string(255),
            'placement_group_name' => $this->string(255),
            'placement_tenancy' => $this->string(255),
            'private_dns_name' => $this->string(255),
            'private_ip_address' => $this->string(16),
            'public_dns_name' => $this->string(255),
            'public_ip_address' => $this->string(16),
            'state_name' => $this->string(127),
            'state_transition_reason' => $this->string(255),
            'subnet_id' => $this->string(23),
            'vpc_id' => $this->string(23),
            'client_token' => $this->string(23),
            'network_interfaces' => $this->text(),
            'root_device_name' => $this->string(255),
            'root_device_type' => $this->string(127),
            'security_groups' => $this->text(),
            'tags' => $this->text(),
            'state_reason' => $this->string(255),
            'description' => $this->text(),
            'remark' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%instances}}');
    }

}
