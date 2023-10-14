<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ArticleTagsController;
use App\Http\Controllers\Api\TagArticlesController;
use App\Http\Controllers\Api\article_tagController;
use App\Http\Controllers\Api\UserArticlesController;
use App\Http\Controllers\Api\CategoryArticlesController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('articles', ArticleController::class);

        // Article Tags
        Route::get('/articles/{article}/tags', [
            ArticleTagsController::class,
            'index',
        ])->name('articles.tags.index');
        Route::post('/articles/{article}/tags/{tag}', [
            ArticleTagsController::class,
            'store',
        ])->name('articles.tags.store');
        Route::delete('/articles/{article}/tags/{tag}', [
            ArticleTagsController::class,
            'destroy',
        ])->name('articles.tags.destroy');

        Route::apiResource('categories', CategoryController::class);

        // Category Articles
        Route::get('/categories/{category}/articles', [
            CategoryArticlesController::class,
            'index',
        ])->name('categories.articles.index');
        Route::post('/categories/{category}/articles', [
            CategoryArticlesController::class,
            'store',
        ])->name('categories.articles.store');

        Route::apiResource('tags', TagController::class);

        // Tag Articles
        Route::get('/tags/{tag}/articles', [
            TagArticlesController::class,
            'index',
        ])->name('tags.articles.index');
        Route::post('/tags/{tag}/articles/{article}', [
            TagArticlesController::class,
            'store',
        ])->name('tags.articles.store');
        Route::delete('/tags/{tag}/articles/{article}', [
            TagArticlesController::class,
            'destroy',
        ])->name('tags.articles.destroy');

        Route::apiResource('users', UserController::class);

        // User Articles
        Route::get('/users/{user}/articles', [
            UserArticlesController::class,
            'index',
        ])->name('users.articles.index');
        Route::post('/users/{user}/articles', [
            UserArticlesController::class,
            'store',
        ])->name('users.articles.store');
    });
