<?php

namespace Uteq\ModelActions\Tests\Fixtures\Actions\TestModel;

use Uteq\ModelActions\Tests\Fixtures\Models\TestModel;

class DoThat
{
    public function __invoke(TestModel $otherName)
    {
        return $otherName;
    }
}
