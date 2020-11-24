<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampleAnnotations;

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

URL::forceScheme('https');

Route::post('/users/login', [SampleAnnotations::class, 'userLogin']);
Route::post('/users/register', [SampleAnnotations::class, 'userRegister']);
Route::get('/users/{email}', [SampleAnnotations::class, 'userDetails']);

Route::get('/', function () {
    return redirect(url(config('jheckdoc.url')));
    // return view('welcome');
});
