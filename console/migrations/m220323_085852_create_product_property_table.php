<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_property}}`.
 */
class m220323_085852_create_product_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_property}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'property_id',
            'product_property',
            'property_id'
        );

        $this->createIndex(
            'product_id',
            'product_property',
            'product_id'
        );

        $this->addForeignKey(
            'product_property_ibfk_1',
            'product_property',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'product_property_ibfk_2',
            'product_property',
            'property_id',
            'property',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('product_property_ibfk_2', 'product_property');
        $this->dropForeignKey('product_property_ibfk_1', 'product_property');

        $this->dropIndex('product_id', 'product_property');
        $this->dropIndex('property_id', 'product_property');

        $this->dropTable('{{%product_property}}');
    }
}
