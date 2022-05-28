<?php

namespace core\services\communication;

use core\entities\communication\Banner;
use core\forms\communication\BannerForm;
use core\repositories\communication\BannerRepository;

class BannerService
{
    private $banners;

    public function __construct(BannerRepository $banners)
    {
        $this->banners = $banners;
    }

    public function add(BannerForm $form)
    {
        $banner = Banner::make($form->name, $form->target_url, $form->image_url, $form->location, $form->is_active);
        $this->banners->save($banner);
        return $banner;
    }

    public function edit($id, BannerForm $form)
    {
        $news = $this->banners->get($id);
        $news->edit($form->name, $form->target_url, $form->image_url, $form->location, $form->is_active);
        $this->banners->save($news);
    }

    public function delete($id)
    {
        $news = $this->banners->get($id);
        $this->banners->remove($news);
    }

}