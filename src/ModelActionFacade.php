<?php

namespace Uteq\ModelActions;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Uteq\ModelActions\ModelAction
 */
class ModelActionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-model-action';
    }
}
