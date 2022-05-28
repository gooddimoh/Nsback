<?php

namespace core\lib\slug;

interface SluggableRepository
{
    public function slugExist($handledSlug);

}