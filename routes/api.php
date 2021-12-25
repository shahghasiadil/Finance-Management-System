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



Route::apiResource('/system_users', 'UsersController');
Route::get('/get_roles', 'UsersController@get_roles');
Route::get('/search_users', 'UsersController@search_users');
Route::get('/get_users', 'UsersController@get_users');
// Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::get('login', [
//     'as' => 'login',
//     'uses' => 'Auth\LoginController@showLoginForm'
// ])->name('login');
