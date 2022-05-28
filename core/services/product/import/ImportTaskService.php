<?php

namespace core\services\product\import;

use core\entities\import\ImportTask;
use core\forms\import\ImportForm;
use core\repositories\import\ImportRepository;

class ImportTaskService
{
    private $imports;

    public function __construct(ImportRepository $imports)
    {
        $this->imports = $imports;
    }

    public function create(ImportForm $form)
    {
        $import = ImportTask::make($form->shopId, $form->groupId, $form->shouldModerate);
        $this->imports->save($import);
        return $import;
    }

    public function start(ImportTask $import)
    {
        $import->start();
        $this->imports->save($import);
    }

    public function stop(ImportTask $import, $message)
    {
        $import->stop();
        $import->addToLog($message);
        $this->imports->save($import);
    }

    public function restart($id)
    {
        $import = $this->imports->get($id);
        $import->restart();
        $this->imports->save($import);
    }

    public function updateProgress(ImportTask $import, $productCounter, $executionCounter)
    {
        $progress = $executionCounter / $productCounter * 100;
        if (($import->progress - $progress) < 5) {
            $import->updateProgress($progress);
            $this->imports->save($import);
        }
    }

    public function addLog(ImportTask $import, $message)
    {
        $import->addToLog($message);
        $this->imports->save($import);
    }

    public function finish(ImportTask $import)
    {
        $import->finish();
        $this->imports->save($import);
    }


}