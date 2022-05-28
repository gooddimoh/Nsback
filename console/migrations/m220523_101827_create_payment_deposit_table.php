<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_deposit}}`.
 */
class m220523_101827_create_payment_deposit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_deposit}}', [
            'user_id' => $this->integer(11)->notNull(),
            'payment_id' => $this->integer(11)->unique()->notNull(),
        ]);

        $this->createIndex(
            'user_id',
            'payment_deposit',
            'user_id'
        );

        $this->addForeignKey(
            'payment_deposit_ibfk_1',
            'payment_deposit',
            'payment_id',
            'payment',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'payment_deposit_ibfk_2',
            'payment_deposit',
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
        $this->dropTable('{{%payment_deposit}}');
    }
}
