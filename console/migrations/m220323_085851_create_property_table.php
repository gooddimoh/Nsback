<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property}}`.
 */
class m220323_085851_create_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property}}', [
            'id' => $this->primaryKey(11),
            'category_id' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
        ]);

        $this->createIndex(
            'category_id',
            'property',
            'category_id'
        );

        $this->addForeignKey(
            'property_ibfk_1',
            'property',
            'category_id',
            'property_category',
            'id',
            'CASCADE',
            'RESTRICT'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%property}}');
    }
}
