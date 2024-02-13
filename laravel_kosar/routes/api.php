<?php

use App\Http\Controllers\BasketController;
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

Route::middleware(['auth.basic'])->group(function(){
    Route::get('getAuthUserItems', [BasketController::class, 'feladat1']);
});

Route::get('baskets', [BasketController::class, 'index']);
Route::get('baskets/{user_id}/{item_id}', [BasketController::class, 'show']);
Route::post('baskets', [BasketController::class, 'store']);

Route::get('getUserItemsByName/{user_id}/{name}', [BasketController::class, 'feladat2']);
Route::delete('deleteOlderThenTwoDays', [BasketController::class, 'feladat3']);
