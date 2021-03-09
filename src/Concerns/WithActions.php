<?php

namespace Uteq\ModelActions\Concerns;

use Uteq\ModelActions\ModelAction;

trait WithActions
{
    protected static $actionClass;

    public static function action($action = null, array $input = [])
    {
        $actionClass = static::$actionClass ??= new ModelAction(
            class: new static,
            namespace: config('model-actions.namespace'),
        );

        return $action
            ? $actionClass->{$action}($input)
            : $actionClass;
    }
}
