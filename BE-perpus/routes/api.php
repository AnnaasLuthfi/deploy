<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BooksController;
use App\Http\Controllers\API\BorrowsController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ProfilesController;
use App\Http\Controllers\API\RolesController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });
    Route::get('/me', [AuthController::class, 'getUser'])->middleware('auth:api');

    Route::apiResource('/role', RolesController::class)->middleware('auth:api','isOwner');

    Route::post('/profile', [ProfilesController::class, 'updateOrCreateProfile'])->middleware('auth:api');

    Route::apiResource('/category', CategoriesController::class);

    Route::apiResource('/book', BooksController::class);

    Route::apiResource('/borrow', BorrowsController::class)->middleware('auth:api');
    Route::post('/borrow', [BorrowsController::class, 'CreateOrUpdateBorrow'])->middleware('auth:api');

    Route::get('bookPopular', [BooksController::class, 'bookPopular']);



});

