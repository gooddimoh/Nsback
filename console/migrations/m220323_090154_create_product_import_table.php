<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_import}}`.
 */
class m220323_090154_create_product_import_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_import}}', [
            'product_id' => $this->integer()->unique()->notNull(),
            'shop_id' => $this->integer()->notNull(),
            'shop_item_id' => $this->integer()->notNull(),
            'own_name' => $this->tinyInteger(1)->notNull(),
            'own_miniature' => $this->tinyInteger(1)->notNull(),
            'own_description' => $this->tinyInteger(1)->notNull(),
            'own_meta' => $this->tinyInteger(1)->notNull(),
            'compare_miniature' => $this->string(246),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);


        $this->createIndex(
            'shop_id',
            'product_import',
            'shop_id'
        );

        $this->addForeignKey(
            'product_import_ibfk_2',
            'product_import',
            'shop_id',
            'shop',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'product_import_ibfk_3',
            'product_import',
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
        $this->dropForeignKey('product_import_ibfk_3', 'product_import');
        $this->dropForeignKey('product_import_ibfk_2', 'product_import');
        $this->dropIndex('shop_id', 'product_import');
        $this->dropTable('{{%product_import}}');
    }
}
