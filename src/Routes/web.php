<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => '\JheckDoc\JheckDocLaravel\Http\Controllers'], function(Router $router){
    $router->get( trim(config('jheckdoc.jheckdoc_assets'), '/') . '/{asset}', [
        'as' => 'jheckdoc.asset',
        'uses' => 'JheckdocAssetsController@index',
    ]);

    Route::get(config('jheckdoc.url'), function () {
        return view('jheckdoc::main');
    });
});



