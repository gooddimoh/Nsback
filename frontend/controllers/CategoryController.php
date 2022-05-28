<?php

namespace frontend\controllers;

use core\entities\product\Category;
use core\entities\product\Group;
use core\readModels\ProductReadRepository;
use core\readModels\GroupReadRepository;
use frontend\forms\Product\ProductSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    private $productRepository;
    private $groupRepository;

    public function __construct($id, $module, ProductReadRepository $productRepository, GroupReadRepository $groupRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->productRepository = $productRepository;
        $this->groupRepository = $groupRepository;
    }

    public function actionIndex()
    {
        return $this->render("index", [
            'productReadRepository' => $this->productRepository,
        ]);
    }

    public function actionView($slug)
    {
        $request = Yii::$app->request;
        $category = $this->findModel($slug);
        return $this->render('view', [
            'category' => $category,
            'groups' => $this->groupRepository->getForMainPage($category->id, $request->get("group_id")),
            'groupsForFilter' => Group::find()->where(['category_id' => $category->id])->all(),
            'searchForm' => new ProductSearch(),
            'queryParams' => Yii::$app->request->queryParams,
        ]);
    }

    /**
     * @param string $slug
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Category::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Группа не найдена');
    }


}