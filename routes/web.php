<?php

use App\Attachment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

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


Auth::routes();

Route::get('/', 'PostController@index')->name('home');
Route::get('/dashboard', 'PostController@index')->name('dashboard');
Route::get('/posts/tag/{tag}', 'PostController@showPostsByTag')->name('posts.bytag');
Route::resource('posts', 'PostController');

Route::resource('tags', 'TagController');

Route::get('/profile', 'ProfileController@index')->name('profile.index');
Route::put('/profile', 'ProfileController@update')->name('profile.update');
