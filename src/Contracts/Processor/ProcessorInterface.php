<?php
/**
 *
 */
namespace Atlasman\LaravelCallback\Contracts\Processor;

use Illuminate\Http\Request;

interface ProcessorInterface
{
    /**
     * process callback
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function execute(Request $request);
}