<?php

namespace console\controllers\tools;

use core\lib\fileGarbage\actions\GarbageEcho;
use core\lib\fileGarbage\actions\GarbageMove;
use core\lib\fileGarbage\FileGarbageCollector;
use core\repositories\product\ProductRepository;
use Yii;
use yii\console\Controller;

class FileGarbageController extends Controller
{
    private ProductRepository $productRepository;
    private $mediaPath;
    private $trashcanPath;

    public function __construct($id, $module, ProductRepository $productRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->productRepository = $productRepository;
        $this->mediaPath = Yii::$app->params['media.productsPath'];
        $this->trashcanPath = Yii::$app->params['media.productsTrashcanPath'];
    }

    public function actionShow()
    {
        $garbage = new FileGarbageCollector($this->mediaPath, $this->productRepository, new GarbageEcho());
        $garbage->start();
    }

    public function actionMove()
    {
        $garbage = new FileGarbageCollector($this->mediaPath, $this->productRepository, new GarbageMove($this->trashcanPath));
        $garbage->start();
    }

}