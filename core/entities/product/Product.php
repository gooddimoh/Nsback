<?php

namespace core\entities\product;

use core\entities\EventTrait;
use core\entities\product\events\ProductPassedModeration;
use core\entities\product\property\ProductProperty;
use core\helpers\product\ProductHelper;
use core\helpers\SettingsHelper;
use DomainException;
use frontend\helpers\UrlNavigator;
use core\lib\fileManager\FileSaver;
use himiklab\sitemap\behaviors\SitemapBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property string $slug
 * @property string|null $miniature
 * @property string|null $description
 * @property string|null $rules
 * @property float $price
 * @property int $minimum_order
 * @property int $quantity
 * @property int $status
 * @property int|null $purchase_counter
 * @property int $updated_at
 * @property int $is_top
 *
 * @property Group $group
 * @property ProductImport $productImport
 * @property ProductMeta $productMeta
 * @property ProductProperty[] $properties
 *
 */
class Product extends \yii\db\ActiveRecord
{
    use EventTrait;

    public const STATUS_ACTIVE = 10;
    public const STATUS_HIDDEN = 20;
    public const STATUS_MODERATION = 30;
    public const STATUS_DELETED = 40;
    public const STATUS_TEMPORARY_UNAVAILABLE = 50;
    public const STATUS_BLOCKED = 60;

    const PUBLIC_STATUS = [self::STATUS_ACTIVE, self::STATUS_TEMPORARY_UNAVAILABLE, self::STATUS_BLOCKED];
    const ALLOW_TO_UPDATE_STATUS = [self::STATUS_ACTIVE, self::STATUS_TEMPORARY_UNAVAILABLE];

    public static function make($groupId, $name, $slug, $description, $rules, $price, $minimumOrder, $quantity, array $propertyList = [])
    {
        $entity = new static();
        $entity->group_id = $groupId;
        $entity->setName($name);
        $entity->slug = $slug;
        $entity->description = $description;
        $entity->rules = $rules;
        $entity->price = $price;
        $entity->minimum_order = $minimumOrder;
        $entity->quantity = $quantity;
        $entity->status = self::STATUS_ACTIVE;
        $entity->updated_at = time();
        $entity->is_top = 0;
        $entity->purchase_counter = 0;
        $entity->setPropertiesByList($propertyList);

        return $entity;
    }

    public function edit($groupId, $name, $slug, $description, $rules, $price, $minimumOrder, $quantity, array $propertyList)
    {
        $this->group_id = $groupId;
        $this->setName($name);
        $this->slug = $slug;
        $this->description = $description;
        $this->rules = $rules;
        $this->price = $price;
        $this->minimum_order = $minimumOrder;
        $this->quantity = $quantity;
        $this->updated_at = time();
        $this->setPropertiesByList($propertyList);
    }

    public function setName($name)
    {
        $this->name = StringHelper::truncate($name, 320);
    }

    public function increasePurchaseCounter()
    {
        $this->purchase_counter = $this->purchase_counter + 1;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setMinimumOrder($minimumOrder)
    {
        $this->minimum_order = $minimumOrder;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function refreshUpdateTime()
    {
        $this->updated_at = time();
    }

    public function isTop()
    {
        return $this->is_top;
    }

    public function setTemporarilyUnavailable()
    {
        $this->status = self::STATUS_TEMPORARY_UNAVAILABLE;
        $this->quantity = 0;
    }

    public function isTemporarilyUnavailable()
    {
        return $this->status === self::STATUS_TEMPORARY_UNAVAILABLE;
    }

    public function isAvailableForPurchase()
    {
        return $this->quantity > 0 && $this->status !== self::STATUS_BLOCKED;
    }

    public function getQuantityForCustomer()
    {
        return $this->isAvailableForPurchase() ? $this->quantity : 0;
    }

    public function getEncodedName()
    {
        return Html::encode($this->name);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPurchaseCounter()
    {
        return (int)$this->purchase_counter;
    }

    public function updateStatus($status)
    {
        if (!in_array($status, array_keys(ProductHelper::statusList()))) {
            throw new DomainException("Статус не найден");
        }

        $this->status = $status;
    }

    public function setMiniature($miniature, $resetImportMiniature = false)
    {
        $this->clearMiniature();
        $this->miniature = $miniature;

        if ($resetImportMiniature && $this->productImport) {
            $productImport = $this->productImport;
            $productImport->setCompareMiniature(null);
            $this->productImport = $productImport;
        }
    }

    public function clearMiniature()
    {
        if ($this->miniature && !self::find()->where(['miniature' => $this->miniature])->count() > 1) {
            @self::createFileSaver()->removeFile($this->miniature);
        }

        $this->miniature = null;
    }

    public function calculateCost($quantity): float
    {
        return round($this->price * $quantity, 2);
    }

    public function editGroup($groupId)
    {
        $this->group_id = $groupId;
    }

    public function editRules($rules)
    {
        $this->rules = $rules;
    }

    public function remove()
    {
        $this->status = self::STATUS_DELETED;
        $this->clearMiniature();
    }

    public function isRecentlyAdded()
    {
        return time() - $this->productImport->created_at < 604800;
    }

    public function toModeration()
    {
        $this->status = self::STATUS_MODERATION;
    }

    public function isInModeration()
    {
        return $this->status === self::STATUS_MODERATION;
    }

    public function hide()
    {
        $this->status = self::STATUS_HIDDEN;
    }

    public function isHidded()
    {
        return $this->status === self::STATUS_HIDDEN;
    }

    public function block()
    {
        $this->status = self::STATUS_BLOCKED;
    }

    public function activate()
    {
        if ($this->isInModeration()) {
            $this->recordEvent(new ProductPassedModeration($this));
        }

        $this->status = self::STATUS_ACTIVE;
    }

    public function isDisplayed()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getMiniature($absoluteUrl = false)
    {
        $relativePath = $this->miniature ? Yii::$app->params['media.productsUrlPath'] . "/" . $this->miniature : $this->getNoPhoto();

        if ($absoluteUrl) {
            return SettingsHelper::getSiteUrl() . "$relativePath";
        }

        return $relativePath;
    }

    public function getNoPhoto()
    {
        return Yii::$app->params['media.noPhotoUrlPath'];
    }

    public function guardMaxQuantity($quantity)
    {
        if ($quantity > $this->quantity) {
            throw new DomainException("Выбранного количества нет в наличии. Доступно: $this->quantity.");
        }
    }

    public function guardMinQuantity($quantity)
    {
        if ($this->minimum_order > $quantity) {
            throw new DomainException("Минимальное количество: $this->minimum_order.");
        }
    }

    // TODO: Временно до находки решения(какого?)
    public static function createFileSaver()
    {
        return new FileSaver(Yii::$app->params['media.productsPath']);
    }

    /** ImportTask */

    public function setImportSettingsByProvider($shopId, $shopItemId, $compareMiniature)
    {
        $productImport = ProductImport::makeByProvider($this, $shopId, $shopItemId, $compareMiniature);
        $this->saveImport($productImport);
    }

    public function setImportSettings($shopId, $shopItemId, $ownMiniature, $ownName, $ownDescription, $ownSeo)
    {
        $productImport = ProductImport::makeByForm($this, $shopId, $shopItemId, $ownMiniature, $ownName, $ownDescription, $ownSeo);
        $this->saveImport($productImport);
    }

    // TODO: Временное решение. Relation для сохранений не работает - после исправления убрать.
    public function saveImport(ProductImport $productImport)
    {
        $productImport->save(false);
    }

    public function editImportSettings($ownMiniature, $ownName, $ownDescription, $ownSeo)
    {
        $productImport = $this->productImport;
        $productImport->edit($ownMiniature, $ownName, $ownDescription, $ownSeo);
        $this->productImport = $productImport;
    }

    public function editImportMeta($ownMeta)
    {
        $productImport = $this->productImport;
        $productImport->editMeta($ownMeta);
        $this->productImport = $productImport;
    }

    public function activateOwnMiniature()
    {
        $import = $this->productImport;
        $import->activateOwnMiniature();
        $this->productImport = $import;
    }

    /** Properties */
    public function isPropertiesEquivalentTo(array $properties)
    {
        return empty(array_diff($properties, ArrayHelper::map($this->properties, 'property_id', 'property_id')));
    }

    public function setPropertiesByList(array $propertyList)
    {
        $properties = [];

        foreach ($propertyList as $propertyId) {
            $properties[] = ProductProperty::make($this, $propertyId);
        }

        $this->properties = $properties;
    }

    public function isPropertyExists($id)
    {
        foreach ($this->properties as $property) {
            Yii::info($id, $property->id);
            if ($property->property_id == $id) {
                return true;
            }
        }
        return false;
    }

    public function getPropertyAsString()
    {
        return implode(", ", array_map(function (ProductProperty $productProperty) {
            return $productProperty->property->name;
        }, $this->properties));
    }

    /** Meta */

    public function setMeta($title, $description, $keywords)
    {
        if (!$this->productMeta) {
            $this->productMeta = ProductMeta::make($this, $title, $description, $keywords);
        } else {
            $seo = $this->productMeta;
            $seo->edit($title, $description, $keywords);
            $this->productMeta = $seo;
        }
    }

    public static function tableName()
    {
        return 'product';
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'miniature' => function () {
                return $this->getMiniature(true);
            },
            'description',
            'rules',
            'price',
            'minimum_order',
            'quantity',
            'purchase_counter',
            'view',
            'group',
            'category' => function () {
                return $this->group->category;
            },
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['productMeta', 'productImport', 'properties'],
            ],
            'sitemap' => [
                'class' => SitemapBehavior::class,
                'scope' => function (ActiveQuery $model) {
                    $model->select(['slug', 'updated_at']);
                    $model->andWhere(['status' => self::PUBLIC_STATUS]);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => Url::to(UrlNavigator::viewProduct($model->slug), "https"),
                        'lastmod' => Yii::$app->formatter->asDate($model->updated_at, "php:Y-m-d\TH:i:sP"),
                        'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                        'priority' => 0.7
                    ];
                }
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Группа',
            'name' => 'Название',
            'miniature' => 'Миниатюра',
            'rules' => 'Индивидуальные правила',
            'description' => 'Описание',
            'price' => 'Цена',
            'minimum_order' => 'Минимальный заказ',
            'quantity' => 'Количество',
            'status' => 'Статус',
            'format' => 'Вид товара',
            'view' => 'Просмотры',
            'purchase_counter' => 'Кол-во покупок',
            'is_top' => 'Топ',
            'properties' => 'Свойства',
        ];
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

    /**
     * Gets query for [[ProductImport]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImport()
    {
        return $this->hasOne(ProductImport::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductMeta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductMeta()
    {
        return $this->hasOne(ProductMeta::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(ProductProperty::class, ['product_id' => 'id']);
    }

}
