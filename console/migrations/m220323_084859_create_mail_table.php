<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mail}}`.
 */
class m220323_084859_create_mail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%mail}}', [
            'id' => $this->primaryKey(),
            'uni_email_id' => $this->bigInteger(),
            'email' => $this->string(246)->notNull(),
            'status' => $this->string(128),
            'date' => $this->integer()->notNull()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail}}');
    }
}
