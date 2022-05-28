<?php

namespace core\entities\import;

use core\entities\product\Group;
use core\entities\shop\Shop;
use Yii;

/**
 * This is the model class for table "import".
 *
 * @property int $id
 * @property int $shop_id
 * @property int $group_id
 * @property int $progress
 * @property int $status
 * @property int $should_moderate
 * @property string|null $log
 * @property int $created_at
 * @property int|null $finish_at
 *
 * @property Shop $shop
 * @property Group $group
 */
class ImportTask extends \yii\db\ActiveRecord
{
    public const STATUS_NEW = 10;
    public const STATUS_PROGRESS = 20;
    public const STATUS_FINISH = 30;
    public const STATUS_STOP = 40;

    public static function make($shopId, $groupId, $shouldModerate)
    {
        $entity = new static();
        $entity->shop_id = $shopId;
        $entity->group_id = $groupId;
        $entity->should_moderate = $shouldModerate;
        $entity->status = self::STATUS_NEW;
        $entity->created_at = time();

        return $entity;
    }

    public function start()
    {
        $this->status = self::STATUS_PROGRESS;
    }

    public function stop()
    {
        $this->status = self::STATUS_STOP;
    }

    public function finish()
    {
        $this->status = self::STATUS_FINISH;
        $this->progress = 100;
        $this->finish_at = time();
    }

    public function updateProgress($progress)
    {
        $this->progress = $progress;
    }

    public function restart()
    {
        if (!$this->isStopped()) {
            throw new \DomainException("Only import stopped import can be relaunched");
        }

        $this->status = self::STATUS_NEW;
        $this->progress = 0;
        $this->log = null;
    }

    public function isStopped()
    {
        return $this->status === self::STATUS_STOP;
    }

    public function isProgressFull()
    {
        return $this->progress === 100;
    }

    public function addToLog($message)
    {
        $time = Yii::$app->formatter->asDatetime(time());
        $this->log .= "[$time] $message\n";
    }

    public static function tableName()
    {
        return 'import_task';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Магазин',
            'group_id' => 'Группа',
            'progress' => 'Прогресс',
            'should_moderate' => 'Модерировать товары',
            'log' => 'Лог',
            'created_at' => 'Время начала',
            'finish_at' => 'Время финиша',
        ];
    }

    /**
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}
