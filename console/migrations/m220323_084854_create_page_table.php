<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m220323_084854_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'slug' => $this->string(128)->unique()->notNull(),
            'title' => $this->string(246)->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->smallInteger(6)->notNull()->defaultValue(10),
            'meta_description' => $this->text(),
            'meta_keywords' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
