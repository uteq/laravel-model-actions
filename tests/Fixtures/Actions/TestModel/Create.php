<?php

namespace Uteq\ModelActions\Tests\Fixtures\Actions\TestModel;

use Uteq\ModelActions\Tests\Fixtures\Models\TestModel;

class Create
{
    public function __invoke(TestModel $model, $name)
    {
        return $name;
    }
}
