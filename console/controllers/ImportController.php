<?php

namespace console\controllers;

use core\readModels\ImportReadRepository;
use core\services\product\import\ImportDelivery;
use core\services\MutexManager;
use yii\console\Controller;

class ImportController extends Controller
{
    private $importer;
    private $tasks;
    private $mutexManager;

    public function __construct($id, $module, ImportDelivery $importer, ImportReadRepository $tasks, MutexManager $mutexManager, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->importer = $importer;
        $this->tasks = $tasks;
        $this->mutexManager = $mutexManager;
    }

    public function actionTasks()
    {
        $this->mutexManager->execute(function () {
            foreach ($this->tasks->getToLaunch() as $import) {
                $this->stdout("{$import->id}\n");
                $this->importer->importByTask($import);
            }
        }, "ImportController::actionTasks");

    }

}