<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneCardsCatgeoryController;
use App\Http\Controllers\PhoneCardsDetailsController;
use App\Http\Controllers\PhoneCardIndividualController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\ExchangeRateController;
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

//  Card Details that are shown to clients to sell
Route::get('admin/phoneCardDetails', [PhoneCardsDetailsController:: class, 'index']);
Route::get('admin/phoneCardStock', [PhoneCardsDetailsController:: class, 'getstock']);
Route::post('admin/phoneCardDetails', [PhoneCardsDetailsController:: class, 'store']);
Route::post('admin/userCSV', [PhoneCardsDetailsController::class, 'addCsv']);
Route::patch('admin/phoneCardDetails/{id}', [PhoneCardsDetailsController:: class, 'update']);
Route::delete('admin/phoneCardDetails/{id}', [PhoneCardsDetailsController:: class, 'destroy']);

// Individual Card Details
Route::get('admin/IndividualCardDetails', [PhoneCardIndividualController:: class, 'index']);
Route::post('admin/IndividualCardDetails', [PhoneCardIndividualController:: class, 'store']);
Route::post('admin/IndividualCardDetailsCSV', [PhoneCardIndividualController::class, 'addCsv']);
Route::patch('admin/IndividualCardDetails/{id}', [PhoneCardIndividualController:: class, 'update']);
Route::delete('admin/IndividualCardDetails/{id}', [PhoneCardIndividualController:: class, 'destroy']);

// Transactions History
Route::get('admin/transactionsHistory', [TransactionHistoryController:: class, 'index']);
Route::get('admin/transactionsHistory/{id}' , [TransactionHistoryController::class, 'showId']);
Route::post('admin/transactionsHistory', [TransactionHistoryController:: class, 'store']);

Route::get('admin/exchangeRate', [ExchangeRateController:: class, 'index']);
Route::patch('admin/exchangeRate/{id}', [ExchangeRateController:: class, 'update']);




