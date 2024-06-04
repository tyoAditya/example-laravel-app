<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $registry = \Prometheus\CollectorRegistry::getDefault();
    // getOrRegisterCounter(string $namespace, string $name, string $help, $labels = [])
    // $counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);
    // $counter->incBy(3, ['blue']);

    $counter = $registry->getOrRegisterCounter('namespace', 'request_count', '', ['code','method','url']);
    $counter->incBy(1, ['200','GET', '/']);

    return ['Laravel' => app()->version()];
});

Route::get('/metrics', [MetricController::class, 'show']);


require __DIR__.'/auth.php';
