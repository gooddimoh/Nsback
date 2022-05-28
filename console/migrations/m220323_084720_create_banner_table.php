<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner}}`.
 */
class m220323_084720_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'target_url' => $this->string(246)->notNull(),
            'image_url' => $this->string(246)->notNull(),
            'location' => $this->smallInteger(6)->notNull(),
            'is_active' => $this->tinyInteger(1)->notNull()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banner}}');
    }
}
