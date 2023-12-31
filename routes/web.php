<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;

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

/*frontend pages*/
Route::get('/', [\App\Http\Controllers\LandingPageController::class,'index'])->name('front-page');
Route::get('/single-page/{article}', [\App\Http\Controllers\LandingPageController::class,'single'])->name('single-blog');
Route::get('/create', [\App\Http\Controllers\LandingPageController::class,'create'])->name('create-article');
Route::post('/store-front', [\App\Http\Controllers\LandingPageController::class,'storeFront'])->name('store-data-article');
/*edit*/
Route::get('/edit-article/{article}', [\App\Http\Controllers\LandingPageController::class,'EditFront'])->name('edit_article');
/*update*/
Route::patch('/article-update/{article}',[\App\Http\Controllers\LandingPageController::class,'UpdateFront'])->name('article_update');
/*delete*/
Route::delete('/article-delete/{article}',[\App\Http\Controllers\LandingPageController::class,'destroy'])->name('article_delete');
Route::get('/dashboard', [\App\Http\Controllers\LandingPageController::class,'DashBoard'])->name('dashboard');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('articles', ArticleController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class);
        Route::resource('users', UserController::class);
    });
