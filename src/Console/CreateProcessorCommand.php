<?php
/**
 *
 */
namespace Atlasman\LaravelCallback\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Atlasman\LaravelCallback\Exceptions\FileAlreadyExistsException;
use Atlasman\LaravelCallback\Exceptions\FileNotFoundException;

class CreateProcessorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:cb:processor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new callback processor class';

    /**
     * [$processorName description]
     * @var [type]
     */
    protected $processorName;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->processorName = $this->argument('name');

        $filesystem = new Filesystem;

        if ($filesystem->exists($path = $this->getPath()) && !$this->option('force')) {
            throw new FileAlreadyExistsException($path);
        }
        if (!$filesystem->isDirectory($dir = dirname($path))) {
            $filesystem->makeDirectory($dir, 0755, true, true);
        }

        $stubContent = $this->getStub();


        $content = str_replace('$NAMESPACE$', $this->getNamespace(), $stubContent);
        $content = str_replace('$CLASS$', $this->getClassName(), $content);

        $filesystem->put($path, $content);

        $this->info('Processor created successfully.');
    }

    /**
     * computed file path
     * @return [type] [description]
     */
    protected function getPath()
    {
        return app_path('Callback/Processors/'.$this->getProcessorName().'Processor.php');
    }

    /**
     * get namespace
     * @return [type] [description]
     */
    protected function getNamespace()
    {
        $appNamespace = rtrim(\Illuminate\Container\Container::getInstance()->getNamespace(), '\\');
        $segments =  explode('/', $this->getProcessorName());
        array_pop($segments);
        $segments = array_merge([$appNamespace, 'Callback', 'Processors'], $segments);
        $namespace = implode("\\", $segments);
        return $namespace;
    }

     /**
     * Get name input.
     *
     * @return string
     */
    protected function getProcessorName()
    {
        $name = $this->processorName;
        if (str_contains($name, '\\')) {
            $name = str_replace('\\', '/', $name);
        }
        if (str_contains($name, '/')) {
            $name = str_replace('/', '/', $name);
        }

        return Str::studly(str_replace(' ', '/', ucwords(str_replace('/', ' ', $name))));
    }

    /**
     * [getClassName description]
     * @return [type] [description]
     */
    protected function getClassName()
    {
        return class_basename($this->getProcessorName());
    }

    /**
     * [getStub description]
     * @return [type] [description]
     */
    protected function getStub()
    {
        $path = __DIR__.'/../../stubs/CallbackProcessor.stub';

        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }

        return file_get_contents($path);
    }

    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of callback.', null],
        ];
    }

    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Force the creation if file already exists.', null],
        ];
    }
}