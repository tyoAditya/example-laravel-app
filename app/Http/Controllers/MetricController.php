<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prometheus\RenderTextFormat;

class MetricController extends Controller
{
    public function show(Request $request): Response
    {
        \Prometheus\Storage\Redis::setDefaultOptions(
            [
                'host' => 'localhost',
                'port' => 6379,
                'password' => null,
                'timeout' => 0.1, // in seconds
                'read_timeout' => '10', // in seconds
                'persistent_connections' => false
            ]
        );

        $registry = \Prometheus\CollectorRegistry::getDefault();
        
        $renderer = new RenderTextFormat();
        $result = $renderer->render($registry->getMetricFamilySamples());
        // var_dump($result);die;

        // header('Content-type: ' . RenderTextFormat::MIME_TYPE);
        // echo $result;

        // return response($result, 200)->header('Content-type:', RenderTextFormat::MIME_TYPE);
        return response($result, 200)->header('Content-type:', "text/html");
        // return response()->json(['status' => 'verification-link-sent']);
        // return response()->noContent();
    }
}
