<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rules_template}}`.
 */
class m220323_084817_create_rules_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rules_template}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'content' => $this->text()->notNull(),
            'position' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rules_template}}');
    }
}
