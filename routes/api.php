<?php

use Illuminate\Http\Request;

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
// Route::group(['middleware' => 'auth:api'], function(){
//    Route::get('user', function(Request $request) {
//        dd($request->user());
//    });
// });
// Route::group(['middleware' => 'auth:api'], function () {
//     	Route::get('administrators','Api\AdministratorController@index');
// 	});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// // Route::group(['middleware' => ['auth']], function () {	
// // 	Route::get('administrators','Api\AdministratorController@index');
// // });
// Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    
//     Route::get('administrators','Api\AdministratorController@index');

// });
// Route::resource('generos','Api\GenreController');

// Route::resource('motivos-texto','Api\MotivationTextsController');
// Route::resource('administradores','Api\AdministratorController');
// Route::post('sendEmail','Api\AdministratorController@sendEmail');

// Route::resource('motivos-usuario','Api\MotivationUsersController');
// Route::resource('comandos','Api\CommandsController');


// Route::resource('summernote','Api\SummernotesController');
// Route::get('summernote/{summernote}/leer', 'Api\SummernotesController@showContent')->name('summernote.showContent');
// Route::get('summernote/{summernote}', 'Api\SummernotesController@show');








// Route::get('summernotes/{id}','Api\SummernotesController@index');
// Route::post('search','Api\SearchFiltersController@filter');
// Route::get('search','Api\SearchFiltersController@indexData');


