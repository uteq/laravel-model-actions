<?php

namespace Uteq\ModelActions\Concerns;

use Uteq\ModelActions\ModelAction;

trait WithActions
{
    protected static $actionClassMap = [];

    public static function do($action = null, ...$input)
    {
        return (new static)->action($action, ...$input);
    }

    public function action($action = null, ...$input)
    {
        $key = md5(static::class . '.' . $action);

        $actionClass = static::$actionClassMap[$key] ??= new ModelAction(
            class: $this ?? static::class,
            namespace: config('model-actions.namespace'),
        );

        return $action
            ? $actionClass->{$action}(...$input)
            : $actionClass;
    }
}
