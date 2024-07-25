<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

// Bunu eklememin sebebi ileriye dönük feature testlerini consoldan yazıp kısa yollarla hazırlayabilmektir,
// elimde hiç örnek çıkaracak vaki olmadı ne yazık ki
class MakeCustomTest extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:custom:test {name : The name of the class} {--unit : Create a custom unit test}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:custom:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom tests class';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceModelLowerCasePlural($stub, $name)
            ->replaceModelLowerCase($stub, $name)
            ->replaceModel($stub, $name)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace the model key-word on stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceModel(string &$stub, string $name): MakeCustomTest
    {
        $class_name = $this->getModelName($name);

        $stub = str_replace('DummyModel', $class_name, $stub);

        return $this;
    }

    /**
     * Replace the model for lower on stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceModelLowerCase(string &$stub, string $name): MakeCustomTest
    {
        $class_name = strtolower($this->getModelName($name));
        $stub = str_replace('DummyModelLowerCase', $class_name, $stub);

        return $this;
    }

    /**
     * Replace the model key-word on stub (plural0.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceModelLowerCasePlural(string &$stub, string $name): MakeCustomTest
    {
        $class_name = Str::plural(strtolower($this->getModelName($name)));
        $stub = str_replace('DummyModelPluralLowerCasePlural', $class_name, $stub);

        return $this;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        // if you wanted, can use flag --unit for unit
        if ($this->option('unit')) {
            return $rootNamespace.'\Unit';
        } else {
            return $rootNamespace.'\Feature';
        }
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('tests').str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('unit')) {
            return __DIR__.'/Stubs/unit-test.stub';
        }

        return __DIR__.'/Stubs/feature-test.stub';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace(): string
    {
        return 'Tests';
    }

    /**
     * @param string $name
     * @return string
     */
    private function getModelName(string $name): string
    {
        return substr(str_replace($this->getNamespace($name).'\\', '', $name), 0, -4);
    }
}
