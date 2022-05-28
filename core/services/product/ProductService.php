<?php

namespace core\services\product;

use core\entities\product\dto\Meta;
use core\entities\product\Product;
use core\entities\product\dto\ProductFromProvider;
use core\entities\shop\Shop;
use core\forms\product\ProductCreateImportForm;
use core\forms\product\ProductForm;
use core\forms\product\ProductImportForm;
use core\forms\product\ProductMetaForm;
use core\forms\product\UrlForm;
use core\lib\fileManager\FileSaver;
use core\lib\markup\MarkupManager;
use core\lib\slug\SlugCreator;
use core\repositories\product\ProductRepository;
use core\repositories\product\GroupRepository;
use Yii;

/**
 * Class ProductService
 * @package core\services\product
 */
class ProductService
{
    private $products;
    private $fileSaver;

    public function __construct(ProductRepository $product)
    {
        $this->products = $product;
        $this->fileSaver = new FileSaver(Yii::$app->params['media.productsPath']); // TODO: Временно до находки решения
    }

    public function addByForm(ProductForm $form)
    {
        $f = $form;
        $product = Product::make($f->groupId,
            $f->name,
            $this->formatSlug($f->name),
            $f->description,
            $f->rules,
            $f->price,
            $f->minimumOrder,
            $f->quantity,
            $f->properties
        );

        if ($f->miniature) {
            $fileName = $this->fileSaver->storeFile($f->miniature);
            $product->setMiniature($fileName);
        }

        $this->products->save($product);

        return $product;
    }

    public function editByForm(ProductForm $form, $id)
    {
        $product = $this->products->get($id);
        $f = $form;

        $product->edit($f->groupId,
            $f->name,
            $this->formatSlug($f->name, $f->slug),
            $f->description,
            $f->rules,
            $f->price,
            $f->minimumOrder,
            $f->quantity,
            $f->properties);
        if ($f->miniature) {
            $product->setMiniature($this->fileSaver->storeFile($f->miniature), true);
        }

        $this->products->save($product);
    }

    public function editUrl(UrlForm $form, $id)
    {
        $product = $this->products->get($id);
        $product->setSlug($form->slug);
        $this->products->save($product);
    }

    public function editStatus($status, $id)
    {
        $product = $this->products->get($id);
        $product->updateStatus($status);
        $this->products->save($product);
    }

    protected function formatSlug($name, $slug = null)
    {
        $slugCreator = new SlugCreator($this->products);
        return $slugCreator->formatSlug($name, $slug);
    }

    public function createImportSettings(ProductCreateImportForm $createForm, ProductImportForm $settingsForm, $id)
    {
        $product = $this->products->get($id);
        $product->setImportSettings($createForm->shopId,
            $createForm->shopItemId,
            $settingsForm->ownMiniature,
            $settingsForm->ownName,
            $settingsForm->ownDescription,
            $settingsForm->ownSeo
        );
        $this->products->save($product);
    }

    public function editImportSettings(ProductImportForm $form, $id)
    {
        $product = $this->products->get($id);
        $product->editImportSettings($form->ownMiniature, $form->ownName, $form->ownDescription, $form->ownSeo);
        $this->products->save($product);
    }

    public function editMeta(ProductMetaForm $form, $id)
    {
        $product = $this->products->get($id);
        $product->setMeta($form->title, $form->description, $form->keywords);

        if ($product->productImport) {
            $product->editImportMeta($form->disableImportChange);
        }

        $this->products->save($product);
    }

    public function increasePurchaseCounter($id)
    {
        $product = $this->products->get($id);
        $product->increasePurchaseCounter();
        $this->products->save($product);
    }

    public function temporarilyUnavailable(Product $product)
    {
        $product->setTemporarilyUnavailable();
        $this->products->save($product);
    }

    public function hide($id)
    {
        $product = $this->products->get($id);
        $product->hide();
        $this->products->save($product);
    }

    public function display($id)
    {
        $product = $this->products->get($id);
        $product->activate();
        $this->products->save($product);
    }

    public function remove($id)
    {
        $product = $this->products->get($id);
        $product->remove();
        $this->products->save($product);
    }

}