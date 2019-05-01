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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');

// Route::group(['as' => 'products.', 'prefix' => 'products'], function(){
//   Route::get('all', 'ProductController@all')->name('all');
// });
//
// Route::group(['as' => 'category.', 'prefix' => 'products'], function(){
//   Route::get('/{category}', 'ProductController@getProducts')->name('products');
// });

Route::group(['as' => 'products.', 'prefix' => 'products'], function() {
  Route::get('/', 'ProductController@show')->name('all');
  Route::get('/{product}', 'ProductController@single')->name('single');
});

Route::group(['as' => 'admin.', 'middleware' => ['auth','admin'], 'prefix' => 'admin'], function() {

  Route::get('category/{category}/remove', 'CategoryController@remove')->name('category.remove');
  Route::get('category/trash', 'CategoryController@remove')->name('category.trash');
  Route::get('category/recover/{id}', 'CategoryController@recoverCat')->name('category.recover');

  Route::get('products/{product}/remove', 'ProductController@remove')->name('products.remove');
  Route::get('products/trash', 'ProductController@trash')->name('products.trash');
  Route::get('products/recover/{id}', 'ProductController@recoverProduct')->name('products.recover');

  Route::view('product/extras', 'admin.partials.extras')->name('product.extras');

  Route::get('profile/{profile}/remove', 'ProfileController@remove')->name('profile.remove');
  Route::get('profile/trash', 'ProfileController@trash')->name('profile.trash');
  Route::get('profile/recover/{id}', 'ProfileController@recoverProfile')->name('profile.recover');
  Route::view('profile/roles', 'admin.partials.extras')->name('profile.extras');

  Route::get('profile/states/{id?}', 'ProfileController@getStates')->name('profile.states');
  Route::get('profile/cities/{id?}', 'ProfileController@getCities')->name('profile.cities');

  Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');

  Route::resource('products', 'ProductController');
  Route::resource('category', 'CategoryController');
  Route::resource('profile', 'ProfileController');
});
