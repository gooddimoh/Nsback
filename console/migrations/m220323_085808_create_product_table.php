<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m220323_085808_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(492)->notNull(),
            'group_id' => $this->integer()->notNull(),
            'name' => $this->string(340)->notNull(),
            'miniature' => $this->string(246),
            'description' => $this->text(),
            'rules' => $this->text(),
            'price' => $this->float()->notNull(),
            'minimum_order' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'purchase_counter' => $this->integer(),
            'updated_at' => $this->integer()->notNull(),
            'is_top' => $this->tinyInteger(1)->defaultValue(0)->notNull()
        ]);

        $this->createIndex(
            'group_id',
            'product',
            'group_id'
        );

        $this->addForeignKey(
            'product_ibfk_1',
            'product',
            'group_id',
            'group',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
