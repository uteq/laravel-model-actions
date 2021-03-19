<?php

namespace Uteq\ModelActions\Tests\Fixtures\Actions\TestModel;

use Uteq\ModelActions\Tests\Fixtures\Models\TestModel;

class Update
{
    public function __invoke(TestModel $model, $input = [], $blaat = [])
    {
        return $model;
    }
}
