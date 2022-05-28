<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m220323_090259_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(128)->unique()->notNull(),
            'user_id' => $this->integer(),
            'product_id' => $this->integer()->notNull(),
            'invoice_id' => $this->string(128),
            'quantity' => $this->integer()->notNull(),
            'cost' => $this->float()->notNull(),
            'email' => $this->string(246)->notNull(),
            'status' => $this->smallInteger(11)->notNull(),
            'file' => $this->string(246),
            'result' => $this->text(),
            'downloaded_at' => $this->integer(),
            'error_data' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'ip' => $this->string(128)->notNull(),
        ]);

        $this->addForeignKey(
            'order_ibfk_2',
            'order',
            'user_id',
            'user',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            'product_id',
            'order',
            'product_id'
        );

        $this->addForeignKey(
            'order_ibfk_3',
            'order',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('order_ibfk_3', 'order');
        $this->dropForeignKey('order_ibfk_2', 'order');
        $this->dropIndex('product_id', 'order');
        $this->dropTable('{{%order}}');
    }
}
