<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%leqshop}}`.
 */
class m220323_090118_create_leqshop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%leqshop}}', [
            'shop_id' => $this->integer()->unique()->notNull(),
            'domain' => $this->string(128)->notNull(),
            'api_key_public' => $this->string(128)->notNull(),
            'api_key_private' => $this->string(128)->notNull(),
            'product_key' => $this->string(128)->notNull(),
            'create_order_key' => $this->string(128)->notNull(),
            'user_email' => $this->string(128),
            'user_token' => $this->string(128)->notNull()
        ]);

        $this->addForeignKey(
            'leqshop_ibfk_1',
            'leqshop',
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
        $this->dropTable('{{%leqshop}}');
    }
}
