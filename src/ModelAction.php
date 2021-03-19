<?php

namespace Uteq\ModelActions;

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
    ) {
        $this->init();
    }

    public function init()
    {
        $this->namespace = $this->getNamespace();

        $this->filesystem ??= new Filesystem;

        $this->actions = collect($this->filesystem->allFiles($this->getPath()))
            ->mapWithKeys(fn (SplFileInfo $file) => [
                lcfirst($file->getBasename('.php')) => $this->namespace . '\\' . $file->getBasename('.php'),
            ])
            ->toArray();
    }

    public function getNamespace(): string
    {
        if ($this->namespace) {
            $filename = Str::of($this->class::class)->afterLast('\\');

            return $this->namespace . '\\' . $filename;
        }

        return str_replace('\\Models\\', '\\Actions\\', $this->class::class);
    }

    public function getPath(): string
    {
        $class = new ReflectionClass(new ($this->class::class));
        $rootPath = Str::beforeLast(Str::beforeLast($class->getFileName(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR);

        if (config('model-actions.namespace')) {
            return $this->generatePathFromNamespace($this->namespace);
        }

        return realpath($rootPath . DIRECTORY_SEPARATOR . '/Actions');
    }

    public static function generatePathFromNamespace($namespace)
    {
        $path = config('model-actions.path', app('path'));
        $name = Str::of($namespace)->finish('\\')
            ->replaceFirst(config('model-actions.app_namespace', app()->getNamespace()), '');

        return $path . '/' . str_replace('\\', '/', $name);
    }

    public function getName(): string
    {
        return (new ReflectionClass($this->class))->getShortName();
    }

    public function __call($method, $arguments)
    {
        if ($actionClass = $this->resolveActionClass($method)) {
            $actionMethod = config('model-actions.method') ?: '__invoke';
            $action = app()->make($actionClass);

            if ($this->class->getKey()) {
                $arguments['model'] = $this->class;
            }

            return ImplicitlyBoundMethod::call(app(), [$action, $actionMethod], $arguments);
        }

        $class = $this->namespace . '\\' . ucfirst($method);

        throw new \Exception(sprintf('Class not found `%s`', $class), 500);
    }

    public function resolveActionClass($method)
    {
        if (isset($this->actions[$method])) {
            return $this->actions[$method];
        }

        if (in_array($method, $this->actions)) {
            return $method;
        }

        return null;
    }
}
