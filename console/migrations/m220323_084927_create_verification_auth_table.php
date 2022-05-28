<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%verification_auth}}`.
 */
class m220323_084927_create_verification_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%verification_auth}}', [
            'hash' => $this->string(50),
            'addressee' => $this->string(100),
            'user_id' => $this->integer()->notNull(),
            'verify_code' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'resend_at' => $this->integer()->notNull(),
            'ip' => $this->string(128)->notNull(),
            'is_confirmed' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'attempts' => $this->integer()->notNull()->defaultValue(0)
        ]);

        $this->addPrimaryKey(
            'pk-verification_auth-hash',
            'verification_auth',
            'hash'
        );

        $this->createIndex(
            'user_id',
            'verification_auth',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%verification_auth}}');
    }
}
