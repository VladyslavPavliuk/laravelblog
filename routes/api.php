<?php

use App\Models\Dog;
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

Route::namespace('Api')->group(function (){
    Route::apiResource('dogs', 'DogsController');
});

Route::get('dogs', function (){
   return response(Dog::all())
       ->header('X-Greatness-Index', 12);
});

//Route::get('dogs', function (Request $request){
//    return ($request->header('Accept'));
//});

