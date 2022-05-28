<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group}}`.
 */
class m220323_085746_create_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'slug' => $this->string(128)->unique()->notNull(),
            'name' => $this->string(128)->notNull(),
            'meta_title' => $this->string(128),
            'meta_keywords' => $this->text(),
            'meta_description' => $this->text(),
            'position' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            'category_id',
            'group',
            'category_id'
        );

        $this->addForeignKey(
            'group_ibfk_1',
            'group',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%group}}');
    }
}
