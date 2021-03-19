<?php

namespace Uteq\ModelActions\Tests\Fixtures\OtherNamespaceActions\TestModel;

class Create
{
    public function __invoke($unique)
    {
        return $unique;
    }
}
