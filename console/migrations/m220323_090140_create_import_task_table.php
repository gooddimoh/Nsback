<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%import_task}}`.
 */
class m220323_090140_create_import_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%import_task}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'group_id' => $this->integer()->notNull(),
            'progress' => $this->smallInteger(2)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'should_moderate' => $this->tinyInteger(1)->notNull(),
            'log' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'finish_at' => $this->integer()
        ]);

        $this->createIndex(
            'shop_id',
            'import_task',
            'shop_id'
        );

        $this->createIndex(
            'group_id',
            'import_task',
            'group_id'
        );

        $this->addForeignKey(
            'import_task_ibfk_1',
            'import_task',
            'group_id',
            'group',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'import_task_ibfk_2',
            'import_task',
            'shop_id',
            'shop',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%import_task}}');
    }
}
