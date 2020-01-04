<?php

namespace Atlasman\LaravelCallback\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Atlasman\LaravelCallback\Contracts\Processor\ProcessorInterface;

class CallbackController extends Controller
{
    /**
     * execute
     * @param  Request $request [description]
     * @param  string  $type    [description]
     * @param  string  $subtype [description]
     * @return [type]           [description]
     */
    public function execute(Request $request, $type, $subtype = '')
    {
        $type = strtolower(trim($type));
        $subtype = strtolower(trim($subtype));

        $processorConf = config('laracallback.provider');
        $args = [$processorConf['prefix'], $type];

        if ($subtype) {
            $args[] = $subtype;
        }

        $provider = implode($processorConf['separator'], $args);

        try {
            if (App::has($provider)) {
                $processor = App::make($provider);
                if ($processor instanceof ProcessorInterface) {
                    return call_user_func([$processor, 'execute'], $request);
                } else {
                   throw new Exception('Unsupport callback type!');
                }
            } else {
                throw new Exception('Unsupport callback type!');
            }
        } catch (Exception $e) {
            return new JsonResponse([
                'error' => [
                    'code' => '1',
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }
}