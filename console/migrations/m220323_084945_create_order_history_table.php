<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_history}}`.
 */
class m220323_084945_create_order_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%order_history}}', [
            'id' => $this->primaryKey(),
            'hash' => $this->string(128)->notNull(),
            'email' => $this->string(128)->notNull(),
            'created_at' => $this->integer()->notNull()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_history}}');
    }
}
