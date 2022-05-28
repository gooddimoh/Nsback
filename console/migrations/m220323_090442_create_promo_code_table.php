<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promo_code}}`.
 */
class m220323_090442_create_promo_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%promo_code}}', [
            'id' => $this->primaryKey(),
            'comment' => $this->string(246),
            'code' => $this->string(128)->unique()->notNull(),
            'percent' => $this->smallInteger(3)->notNull(),
            'activation_limit' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'date' => $this->integer()->notNull()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promo_code}}');
    }
}
