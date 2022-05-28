<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promo_code_activation}}`.
 */
class m220323_090454_create_promo_code_activation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%promo_code_activation}}', [
            'payment_id' => $this->integer()->unique()->notNull(),
            'promo_id' => $this->integer()->notNull(),
            'percent' => $this->smallInteger(2)->notNull(),
            'discount_amount' => $this->float()->notNull(),
            'date' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex(
            'promo_id',
            'promo_code_activation',
            'promo_id'
        );

        $this->addForeignKey(
            'promo_code_activation_ibfk_1',
            'promo_code_activation',
            'payment_id',
            'payment',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'promo_code_activation_ibfk_2',
            'promo_code_activation',
            'promo_id',
            'promo_code',
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promo_code_activation}}');
    }
}
