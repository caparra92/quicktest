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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::get('/users', 'UsersController@index');
Route::get('/categories', 'CategoriesController@index');
Route::get('/tests', 'TestsController@index');
Route::get('/questions', 'QuestionsController@index');
Route::get('/questions/{question}/{type?}', 'QuestionsController@findQuestions');
Route::get('/tests/print/{id}/', 'TestsController@printTest');

Route::post('/users/new', 'UsersController@store');
Route::post('/categories/new', 'CategoriesController@store');
Route::post('/tests/new', 'TestsController@store');
Route::post('/questions/new', 'QuestionsController@store');

Route::put('/users/{id}', 'UsersController@update');
Route::put('/categories/{id}', 'CategoriesController@update');
Route::put('/tests/{id}', 'TestsController@update');
Route::put('/questions/{id}', 'QuestionsController@update');
Route::put('/questions/add/{id}', 'QuestionsController@add');
Route::put('/questions/remove/{id}', 'QuestionsController@remove');

Route::delete('/users/{id}', 'UsersController@destroy');
Route::delete('/categories/{id}', 'CategoriesController@destroy');
Route::delete('/tests/{id}', 'TestsController@destroy');
Route::delete('/questions/{id}', 'QuestionsController@destroy');
