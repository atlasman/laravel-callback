<?php
/**
 *
 */
namespace Atlasman\LaravelCallback\Processors;

use Illuminate\Http\Request;
use Illuminate\Container\Container as Application;
use Atlasman\LaravelCallback\Contracts\Processor\ProcessorInterface;

abstract class Processor implements ProcessorInterface
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
    * process callback
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    abstract public function execute(Request $request);
}