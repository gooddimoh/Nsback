<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transfer}}`.
 */
class m220323_085038_create_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transfer}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'sum' => $this->float()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'date' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            'user_id',
            'transfer',
            'user_id'
        );

        $this->addForeignKey(
            'transfer_ibfk_1',
            'transfer',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transfer}}');
    }
}
