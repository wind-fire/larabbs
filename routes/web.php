<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

use Illuminate\Support\Facades\Route;

//Route::get('/','PagesController@root')->name('root');
Route::get('/', 'TopicsController@index')->name('root');

/*Auth::routes();

Route::get('/', 'HomeController@index')->name('home');*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('users','UsersController',['only'=>['show','update','edit']]);
/* 上面代码将等同于：

Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
可以看到使用 resource 方法不仅节省很多代码，且严格遵循了 RESTful URI 的规范，在后续的开发中，我们会优先选择 resource 路由。*/


//Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');



Route::resource('categories','CategoriesController',['only'=> ['show']]);

/*上传图片*/
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');


Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
//Route::resource('replies', 'RepliesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

//消息通知显示
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

//后台访问权限
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');