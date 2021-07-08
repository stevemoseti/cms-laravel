<?php

use App\Http\Controllers\Blog\PostsController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;






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

Route::get('/','App\Http\Controllers\WelcomeController@index')->name('welcome'); 
Route::get('blog/posts/{post}',[PostsController::class, 'show'])->name('blog.show'); 
Route::get('blogs/categories/{category}',[PostsController::class, 'category'])->name('blog.category');
Route::get('blogs/tags/{tag}',[PostsController::class, 'tag'])->name('blog.tag');

Auth::routes();


//group middleware of type auth
Route::middleware(['auth'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('categories','App\Http\Controllers\CategoriesController');
        Route::resource('posts','App\Http\Controllers\PostsController');

        //tags
        Route::resource('tags','App\Http\Controllers\tagsController');

        //route for trashed posts
        Route::get('trashed-posts','App\Http\Controllers\PostsController@trashed')->name('trashed-posts.index');
});

Route::middleware(['auth','admin'])->group(function(){
Route::get('users','App\Http\Controllers\UsersController@index')->name('users.index'); 
Route::post('users/{user}/make-admin','App\Http\Controllers\UsersController@makeAdmin')->name('users.make-admin');
Route::get('users/profile', 'App\Http\Controllers\UsersController@edit')->name('users.edit-profile');
Route::put('users/profile','App\Http\Controllers\UsersController@update')->name('users.update-profile');
});