<?php

namespace core\forms\communication;

use core\entities\communication\Banner;
use yii\base\Model;

class BannerForm extends Model
{
    public $name;
    public $target_url;
    public $image_url;
    public $location;
    public $is_active;

    public function __construct(Banner $banner = null, $config = [])
    {
        if ($banner) {
            $this->name = $banner->name;
            $this->target_url = $banner->target_url;
            $this->image_url = $banner->image_url;
            $this->location = $banner->location;
            $this->is_active = $banner->is_active;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'target_url', 'image_url', 'location'], 'required'],
            [['target_url', 'image_url'], 'url'],
            [['name'], 'string', 'max' => 128],
            [['is_active'], 'boolean'],
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => 'Видите только Вы',
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'target_url' => 'Ссылка баннера',
            'image_url' => 'Ссылка на изображение',
            'location' => 'Расположение',
            'is_active' => 'Активно',
        ];
    }
}