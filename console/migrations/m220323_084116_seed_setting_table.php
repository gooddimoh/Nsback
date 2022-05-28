<?php

use yii\db\Migration;

/**
 * Class m220323_084116_seed_setting_table
 */
class m220323_084116_seed_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $settingsSql = '
            INSERT INTO `setting`(`type`, `section`, `key`, `value`, `status`, `description`, `created_at`, `updated_at`)
            VALUES ("string", "main", "disableSite", 0, 1, NULL, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
            INSERT INTO `setting`(`type`, `section`, `key`, `value`, `status`, `description`, `created_at`, `updated_at`)
            VALUES ("string", "main", "disableGoodsUpdate", 0, 1, NULL, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
            INSERT INTO `setting`(`type`, `section`, `key`, `value`, `status`, `description`, `created_at`, `updated_at`)
            VALUES ("string", "main", "disableSiteMessage", 0, 1, NULL, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
        ';

        Yii::$app->db->createCommand($settingsSql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $truncateSql = 'TRUNCATE TABLE `setting`';

        Yii::$app->db->createCommand($truncateSql)->execute();
    }
}
