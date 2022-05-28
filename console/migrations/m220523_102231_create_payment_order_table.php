<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_order}}`.
 */
class m220523_102231_create_payment_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_order}}', [
            'order_id' => $this->integer(11)->unique()->notNull(),
            'payment_id' => $this->integer(11)->unique()->notNull(),
        ]);

        $this->addForeignKey(
            'payment_order_ibfk_1',
            'payment_order',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'payment_order_ibfk_2',
            'payment_order',
            'payment_id',
            'payment',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_order}}');
    }
}
