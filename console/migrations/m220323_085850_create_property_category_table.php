<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_category}}`.
 */
class m220323_085850_create_property_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property_category}}', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%property_category}}');
    }
}
