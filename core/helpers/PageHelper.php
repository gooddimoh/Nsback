<?php

namespace core\helpers;

use core\entities\content\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PageHelper
{
    public static function statusList()
    {
        return [
            Page::STATUS_PUBLIC => 'Опубликовано',
            Page::STATUS_DRAFT => 'Черновик',
            Page::STATUS_REMOVED => 'Удалён',
        ];
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Page::STATUS_PUBLIC:
                $class = 'label label-success';
                break;
            case Page::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Page::STATUS_REMOVED:
                $class = 'label label-danger';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', self::statusName($status), [
            'class' => $class,
        ]);
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

}