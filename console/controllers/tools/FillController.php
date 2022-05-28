<?php

namespace console\controllers\tools;

use core\entities\product\Group;
use core\entities\shop\Shop;
use core\forms\product\CategoryForm;
use core\forms\product\GroupForm;
use core\forms\import\ImportForm;
use core\forms\shop\ShopForm;
use core\services\product\CategoryService;
use core\services\product\GroupService;
use core\services\product\import\ImportDelivery;
use core\services\product\import\ImportTaskService;
use core\services\shop\ShopService;
use Faker\Factory;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use yii\helpers\Console;
use yii\web\UploadedFile;

class FillController extends Controller
{
    private CategoryService $categoryService;
    private GroupService $groupService;
    private ShopService $shopService;
    private ImportTaskService $importService;
    private ImportDelivery $productImporter;

    public function __construct(
        $id,
        $module,
        CategoryService $categoryService,
        GroupService $groupService,
        ImportTaskService $importService,
        ShopService $shopService,
        ImportDelivery $productImporter,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->categoryService = $categoryService;
        $this->groupService = $groupService;
        $this->importService = $importService;
        $this->shopService = $shopService;
        $this->productImporter = $productImporter;
    }

    public function actionInit()
    {
        if (!$this->confirm("Are you sure?")) {
            $this->stdout("Init cancelled\n");
            return ExitCode::OK;
        }

        // Init variables
        $faker = Factory::create("ru_RU");
        $categoryNames = ['Steam', 'Myself', 'Origin', 'EA'];
        $groups = [];

        // Create categories & groups
        foreach ($categoryNames as $categoryName) {
            $category = $this->categoryService->add(new CategoryForm(null, ['name' => $categoryName]));
            $groupLimit = rand(1, 3);

            for ($i = 0; $i < $groupLimit; $i++) {
                $groups[] = $this->groupService->add(new GroupForm(null, ['name' => ucfirst($faker->word()), 'categoryId' => $category->id]));
            }

            $this->stdout("$categoryName created\n");
        }

        // Create test shop
        $shop = $this->shopService->add(new ShopForm(null, [
            'name' => ucfirst($faker->word),
            'shopMarkup' => $faker->numberBetween(5, 15),
            'internalMarkup' => null,
            'platform' => Shop::PLATFORM_RAPTOR,
        ]));
        $this->stdout("Shop $shop->name created\n");

        // Fill products to first group
        $groups = array_reverse($groups);
        $firstGroup = array_pop($groups);

        if ($firstGroup instanceof Group) {
            $this->stdout("[!] Product import started. It can takes few minutes\n", BaseConsole::FG_CYAN);

            $import = $this->importService->create(new ImportForm(['shopId' => $shop->id, 'groupId' => $firstGroup->id, 'shouldModerate' => false]));
            $this->productImporter->importByTask($import);
        }

        return ExitCode::OK;
    }


}