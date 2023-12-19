<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegistrationController;
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
Route::post('/signUp', [RegistrationController::class, 'store']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LogoutController::class, 'logout']);

// prefix with admin so the url will match '/admin/users'

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::controller(UserController::class)->group(function (){
        // Routes that require 'view-users' and 'another-permission' permissions
        Route::get('/users',  'index')->middleware('admin:view-users');
        Route::delete('/users/{id}', 'destroy')->middleware('admin:delete-user');
    });
    
});

// Routes using the same, middleware, prefix and controller
Route::middleware('auth')->group(function (){
    Route::controller(PostController::class)->group(function (){
        Route::get('/posts', 'index')->withoutMiddleware('auth');
        Route::get('/post/{id}', 'show')->withoutMiddleware('auth');
        Route::get('/users/{id}/posts', 'showPost');
        Route::post('/newPost',  'store');
        Route::delete('/post/{id}', 'destroy')->middleware('author:delete-post');
    });
});




