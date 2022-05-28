<?php

namespace core\services\product;

use core\entities\product\RulesTemplate;
use core\forms\product\RulesTemplateForm;
use core\repositories\product\RulesTemplateRepository;

class RulesTemplateService
{
    private $templates;

    public function __construct(RulesTemplateRepository $templates)
    {
        $this->templates = $templates;
    }

    public function add(RulesTemplateForm $form)
    {
        $template = RulesTemplate::make($form->name, $form->content);
        $this->templates->add($template);
        return $template;
    }

    public function edit(RulesTemplateForm $form, $id)
    {
        $template = $this->templates->find($id);
        $template->edit($form->name, $form->content);
        $this->templates->save($template);
    }

    public function delete($id)
    {
        $template = $this->templates->find($id);
        $this->templates->delete($template);
    }

}