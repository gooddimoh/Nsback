<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m220323_085739_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(128)->notNull(),
            'meta_title' => $this->string(128),
            'meta_keywords' => $this->text(),
            'meta_description' => $this->text(),
            'icon' => $this->string(128)->null(),
            'position' => $this->integer()->notNull()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
