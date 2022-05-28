<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_refund}}`.
 */
class m220323_090310_create_order_refund_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_refund}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->unique()->notNull(),
            'bill' => $this->string(128),
            'refund_to_balance' => $this->tinyInteger(1)->defaultValue(0)->notNull(),
            'comment' => $this->string(246),
            'type' => $this->smallInteger()->notNull(),
            'sum' => $this->float()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'order_refund_ibfk_1',
            'order_refund',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_refund}}');
    }
}
