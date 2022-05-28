<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_meta}}`.
 */
class m220323_085833_create_product_meta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_meta}}', [
            'product_id' => $this->integer()->unique()->notNull(),
            'title' => $this->string(128),
            'description' => $this->string(246),
            'keywords' => $this->text()
        ]);

        $this->addForeignKey(
            'product_meta_ibfk_1',
            'product_meta',
            'product_id',
            'product',
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
        $this->dropTable('{{%product_meta}}');
    }
}
