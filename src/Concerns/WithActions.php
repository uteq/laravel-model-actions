<?php

namespace Uteq\ModelActions\Concerns;

use Uteq\ModelActions\ModelAction;

trait WithActions
{
    protected static $actionClass;

    public static function action()
    {
        return static::$actionClass ??= new ModelAction(new static);
    }
}
