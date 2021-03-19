<?php

namespace Uteq\ModelActions\Tests\Fixtures\Actions\TestModel;

use Uteq\ModelActions\Tests\Fixtures\Models\OtherTestModel;

class DoThis
{
    public function __invoke(OtherTestModel $model, array $input = [])
    {
        return $model;
    }
}
