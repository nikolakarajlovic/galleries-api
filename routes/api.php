<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/authors/{user_id}', [UserController::class, 'userGalleries']);
Route::get('/galleries/{gallery}', [GalleryController::class, 'show']);
Route::get('my-galleries', [AuthController::class, 'myGalleries'])->middleware('auth');
Route::post('/galleries', [GalleryController::class, 'store'])->middleware('auth');
Route::put('/galleries/{gallery}', [GalleryController::class, 'update'])->middleware('auth');
Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy'])->middleware('auth');
Route::get('/my-profile', [AuthController::class, 'myProfile'])->middleware('auth');
Route::post('/comments/{gallery}', [CommentController::class, 'store'])->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->middleware('auth');
