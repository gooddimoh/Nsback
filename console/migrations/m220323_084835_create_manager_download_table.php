<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager_download}}`.
 */
class m220323_084835_create_manager_download_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manager_download}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'download_at' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            'user_id',
            'manager_download',
            'user_id'
        );

        $this->createIndex(
            'order_id',
            'manager_download',
            'order_id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%manager_download}}');
    }
}
