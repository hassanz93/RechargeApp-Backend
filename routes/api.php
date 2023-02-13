<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneCardsCatgeoryController;
use App\Http\Controllers\PhoneCardsDetailsController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::get('admin/user' , [UserController::class, 'index']);
Route::get('admin/user/{id}' , [UserController::class, 'showId']);
Route::post('admin/user', [UserController::class, 'store']);
Route::post('admin/userCSV', [UserController::class, 'addCsv']);
Route::get('admin/user/{id}', [UserController::class, 'show']);
Route::patch('admin/user/{id}', [UserController::class, 'update']);
Route::delete('admin/user/{id}', [UserController::class, 'destroy']);

Route::get('main/home', [HomeController:: class, 'index']);

Route::get('main/phoneCardCategory', [PhoneCardsCatgeoryController:: class, 'index']);

Route::get('main/phoneCardDetails', [PhoneCardsDetailsController:: class, 'index']);



