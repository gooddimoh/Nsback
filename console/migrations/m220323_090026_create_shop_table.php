<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop}}`.
 */
class m220323_090026_create_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'shop_markup' => $this->float()->notNull(),
            'internal_markup' => $this->float(),
            'platform' => "ENUM('leqshop', 'djekxa', 'raptor')",
            'status' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop}}');
    }
}
