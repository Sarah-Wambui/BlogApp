<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Routes for user registration, authentication and logout
Route::controller(AuthController::class)->group(function (){
    Route::post('/signUp', 'store');
    Route::post('/login',  'authenticate');
    Route::post('/logout', 'logout');
});


// prefix with admin so the url will match '/admin/users'
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::controller(UserController::class)->group(function (){
        Route::get('/users',  'index')->middleware('admin:view-users');
        Route::delete('/users/{id}', 'destroy')->middleware('admin:delete-user');
    });

});

// Routes using the same, middleware, prefix and controller
Route::middleware('auth')->group(function (){
    Route::controller(PostController::class)->group(function (){
        Route::get('/posts', 'index')->withoutMiddleware('auth');
        Route::get('/post/{id}', 'show')->withoutMiddleware('auth');
        Route::get('/user/{id}/posts', 'showPost')->withoutMiddleware('auth');
        Route::post('/newPost',  'store');
        Route::put('/post/{id}', 'update')->middleware('author:edit-post');
        Route::delete('/post/{id}', 'destroy')->middleware('author:delete-post');
    });
});




