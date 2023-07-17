<?php

namespace PrinceJohn\LaravelConfigBuilder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

/**
 * Known Issues:
 *  - If a key name results int the same name when sanitized then the build will fail.
 *    Example: "foo-bar" and "foo:bar" will both be sanitized into "foo_bar"
 *    Please see implementation of "createValidName" function.
 */
class BuildConfig extends Command
{
    /** @var string */
    protected $signature = 'config:build';

    /** @var string */
    protected $description = 'Convert configs into classes';

    private string $stubPath;

    private string $configPath;

    private string $classPath;

    private string $classNamespace;

    private string $lintCommand;

    public function __construct()
    {
        parent::__construct();

        $this->stubPath = config('config-builder.stub-path');
        $this->configPath = config('config-builder.config-path');
        $this->classPath = config('config-builder.class-path');
        $this->classNamespace = config('config-builder.class-namespace');
        $this->lintCommand = config('config-builder.lint-command');
    }

    public function handle(): void
    {
        $classStub = File::get($this->stubPath.'config.class.stub');

        $files = File::files($this->configPath);

        foreach ($files as $file) {

            $filename = $file->getFilename();

            $configurations = require $this->configPath.$filename;

            $className = str($file->getFilenameWithoutExtension())
                ->studly()
                ->toString();

            [$classString, $nestedclasses] = $this->buildClass($className, $classStub, $configurations);

            $classString = str($classString)
                ->replace('{{namespace}}', $this->classNamespace)
                ->replace(
                    '{{nestedclasses}}',
                    collect($nestedclasses)->join(PHP_EOL)
                )
                ->toString();

            $this->createConfigClass($filename, $classString);
        }

        Process::run($this->lintCommand);

        $this->info('Configurations built successfully');
    }

    private function buildClass(string $className, string $stub, array $configurations): array
    {
        $properties = [];

        $initializations = [];

        $methods = [];

        $nestedclasses = [];

        foreach ($configurations as $key => $value) {

            $type = $this->inferValueType($value);

            $property = $this->createValidName($key);

            $printValue = var_export($value, true);

            $properties[] = PHP_EOL."\tpublic {$type} \${$property};";

            $initializations[] = PHP_EOL."\$this->{$property} = $printValue;";

            if (is_array($value) && Arr::isAssoc($value)) {                
                $nestedclassName = str("{$className}_{$property}")->title()->toString();

                $methods[] = <<<PHP
                    public function {$property}(){
                        return new {$nestedclassName};
                    }
                    PHP;

                $nestedclasses = array_merge($this->buildNestedClass($nestedclassName, $value), $nestedclasses);

            }
        }

        $classString = str($stub)
            ->replace('{{classname}}', $className)
            ->replace('{{properties}}', collect($properties)->join(PHP_EOL))
            ->replace('{{initializations}}', collect($initializations)->join(PHP_EOL))
            ->replace('{{methods}}', collect($methods)->join(PHP_EOL))
            ->toString();

        return [$classString, $nestedclasses];
    }

    private function buildNestedClass(string $className, array $configurations): array
    {
        $classStub = File::get($this->stubPath.'config.nestedclass.stub');

        [$classString, $nestedclasses] = $this->buildClass($className, $classStub, $configurations);

        $nestedclasses[] = $classString;

        return $nestedclasses;
    }

    private function createConfigClass(string $filename, string $content): void
    {
        $filename = str($filename)->studly()->toString();

        if (! File::exists($this->classPath)) {
            File::makeDirectory($this->classPath);
        }

        File::put($this->classPath.$filename, $content);

        $this->info("{$filename} \t --> converted --> \t objects/{$filename}");
    }

    private function inferValueType(mixed $value): string
    {
        //TODO: Identify multiple types. Example: ?string

        return match (gettype($value)) {
            'boolean' => 'bool',
            'integer' => 'int',
            'double' => 'float',
            'string' => 'string',
            'array' => 'array',
            'object' => '\\'.get_class($value),
            default => '',
        };
    }

    private function createValidName(string $string): string
    {
        return str($string)
            ->replace(['-', ' '], '_')
            ->replaceMatches('/[^a-zA-Z0-9_]/', '')
            ->toString();
    }
}
