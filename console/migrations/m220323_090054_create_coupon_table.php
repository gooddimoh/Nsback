<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coupon}}`.
 */
class m220323_090054_create_coupon_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coupon}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'percent' => $this->integer()->notNull(),
            'code' => $this->string(128)->notNull(),
            'comment' => $this->text()
        ]);

        $this->createIndex(
            'shop_id',
            'coupon',
            'shop_id'
        );

        $this->addForeignKey(
            'coupon_ibfk_1',
            'coupon',
            'shop_id',
            'shop',
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
        $this->dropTable('{{%coupon}}');
    }
}
