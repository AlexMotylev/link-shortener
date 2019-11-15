<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/link', 'LinkController@add');
Route::match(['put', 'delete'], '/link/{hash}/{secret_key}', 'LinkController@editDelete')
    ->name('linkEditDelete');

//Route::post('/link', function (Request $request){
//    $link = new \App\Link();
//    $link->short_url = $request->get('link');
//    $link->full_url = $request->get('link');
//    $link->save();
//   return ['test'=>$request->get('link')];
//});
