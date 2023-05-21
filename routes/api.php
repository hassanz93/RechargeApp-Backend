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
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\TopUpTransferController;

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
    Route::post('password', 'password');
});

Route::get('admin/user' , [UserController::class, 'index']);
Route::post('admin/user', [UserController::class, 'store']);
Route::get('admin/user/{id}', [UserController::class, 'show']);
Route::patch('admin/user/{id}', [UserController::class, 'update']);
Route::delete('admin/user/{id}', [UserController::class, 'destroy']);

Route::patch('admin/setlimit/Lbp', [LimitPurchaseController::class, 'setLimitLBP']);
Route::patch('admin/setlimit/Usd', [LimitPurchaseController::class, 'setLimitUSD']);

Route::patch('agent/transfer/{id}', [UserController::class, 'agentTransferBalance']);
Route::patch('admin/transfer/{id}', [UserController::class, 'adminTransferBalance']);

Route::get('main/home', [HomeController:: class, 'index']);

Route::get('main/phoneCardCategory', [PhoneCardsCatgeoryController:: class, 'index']);
Route::post('main/phoneCardCategory', [PhoneCardsCatgeoryController:: class, 'store']);
Route::patch('main/phoneCardCategory/{id}', [PhoneCardsCatgeoryController:: class, 'update']);
Route::delete('main/phoneCardCategory/{id}', [PhoneCardsCatgeoryController:: class, 'destroy']);

//  Card Details that are shown to clients to sell
Route::get('admin/phoneCardDetails', [PhoneCardsDetailsController:: class, 'index']);
Route::get('admin/phoneCardStock', [PhoneCardsDetailsController:: class, 'getstock']);
Route::post('admin/phoneCardDetails', [PhoneCardsDetailsController:: class, 'store']);
Route::patch('admin/phoneCardDetails/{id}', [PhoneCardsDetailsController:: class, 'update']);
Route::delete('admin/phoneCardDetails/{id}', [PhoneCardsDetailsController:: class, 'destroy']);

// Individual Card Details
Route::get('admin/IndividualCardDetails', [PhoneCardIndividualController:: class, 'index']);
Route::post('admin/IndividualCardDetails', [PhoneCardIndividualController:: class, 'store']);
Route::post('admin/IndividualCardDetailsCSV', [PhoneCardIndividualController::class, 'addCsv']);
Route::patch('admin/IndividualCardDetails/{id}', [PhoneCardIndividualController:: class, 'update']);
Route::patch('admin/PurchaseCardDetailsStatus/{id}', [PhoneCardIndividualController:: class, 'purchaseStatus']);
Route::delete('admin/IndividualCardDetails/{id}', [PhoneCardIndividualController:: class, 'destroy']);
Route::get('admin/PurchaseCardDetails/{id}/{quantity}', [PhoneCardIndividualController:: class, 'purchase']);
Route::get('admin/getByUserPurchased', [PhoneCardIndividualController:: class, 'getByUserPurchased']);
Route::get('admin/getByUserPurchasedForAdmin', [PhoneCardIndividualController:: class, 'getByUserPurchasedForAdmin']);

// Transactions History
Route::get('admin/transactionsHistory', [TransactionHistoryController:: class, 'index']);
Route::get('admin/transactionsHistory/{id}' , [TransactionHistoryController::class, 'showId']);
Route::get('admin/showTransactionId/{id}/{cardId}' , [TransactionHistoryController::class, 'showTransactionId']);
Route::get('admin/lastTransactionId' , [TransactionHistoryController::class, 'showLatestPurchaseId']);
Route::post('admin/transactionsHistory', [TransactionHistoryController:: class, 'store']);
Route::get('admin/transactionsHistoryMonth/{month}', [TransactionHistoryController:: class, 'showMonth']);
Route::get('admin/transactionsHistoryMonthforUser/{month}', [TransactionHistoryController:: class, 'showMonthById']);

Route::get('admin/topup', [TopUpTransferController:: class, 'index'] );
Route::get('admin/topups', [TopUpTransferController:: class, 'getAllAgents'] );
Route::get('agent/topup/{id}', [TopUpTransferController:: class, 'getByAgent'] );
Route::post('admin/topup', [TopUpTransferController:: class, 'adminTransferHistory'] );
Route::post('agent/topup', [TopUpTransferController:: class, 'agentTransferHistory'] );
Route::get('admin/topupfilter/{month}', [TopUpTransferController:: class, 'showMonthAdmin'] );
Route::get('agent/topupfilter/{month}', [TopUpTransferController:: class, 'showMonthByAgent'] );
Route::patch('admin/topup/{id}', [TopUpTransferController:: class, 'updateAdmin'] );
Route::patch('agent/topup/{id}', [TopUpTransferController:: class, 'updateAgent'] );

Route::get('admin/exchangeRate', [ExchangeRateController:: class, 'index']);
Route::patch('agent/exchangeRate/{id}', [ExchangeRateController:: class, 'update']);

//Comments
Route::get('admin/comments', [CommentsController::class, 'getComments']);
Route::get('admin/comment' , [CommentsController::class, 'getLastComment']);
Route::post('admin/comment', [CommentsController:: class, 'store']);




