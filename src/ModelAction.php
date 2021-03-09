<?php

namespace Uteq\ModelActions;

use BadMethodCallException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class ModelAction
{
    public function __construct(
        public $class,
        public $namespace = null,
        public ?Filesystem $filesystem = null,
        public array $actions = [],
    )
    {
        $this->init();
    }

    public function init()
    {
        $this->namespace ??= $this->getNamespace();

        $this->filesystem ??= new Filesystem;

        $this->actions = collect($this->filesystem->allFiles($this->getPath()))
            ->mapWithKeys(fn(SplFileInfo $file) => [
                lcfirst($file->getBasename('.php')) => $this->namespace . '\\' . $file->getBasename('.php')
            ])
            ->toArray();
    }

    public function getNamespace(): string
    {
        return str_replace('\\Models\\', '\\Actions\\', $this->class::class);
    }

    public function getPath(): string
    {
        return base_path()
            . DIRECTORY_SEPARATOR
            . str_replace('\\', DIRECTORY_SEPARATOR, (string)Str::before(app_path(), '/App') . DIRECTORY_SEPARATOR . $this->namespace);
    }

    public function getName(): string
    {
        return (new ReflectionClass($this->class))->getShortName();
    }

    public function __call($method, $arguments)
    {
        if (isset($this->actions[$method])) {
            return (new $this->actions[$method])(...$arguments);
        }

        throw new BadMethodCallException(sprintf(
            'Call to undefined method %s::%s()', static::class, $method
        ));
    }
}
