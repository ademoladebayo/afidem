<?php

use App\Http\Middleware\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Cors;


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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware([ActivityLog::class])->group(function () {

    // =============================================================================
    //               BEGINNING OF TRANSACTION ROUTE
    // =============================================================================
    // TRANSACTION {SIGNIN}
    Route::post('signin', 'AdminController@signIn', function () {
    })->middleware(Cors::class)->withoutMiddleware([ActivityLog::class]);

    Route::post('notify', 'NotificationController@notify', function () {
    })->middleware(Cors::class)->withoutMiddleware([ActivityLog::class]);

    Route::post('device-token', 'NotificationController@saveToken', function () {
    })->middleware(Cors::class)->withoutMiddleware([ActivityLog::class]);

    Route::middleware('auth:sanctum')->group(function () {

        // TRANSACTION {EXPENSE MANAGEMENT}
        Route::post('transaction/create-expense', 'TransactionController@createExpense', function () {
        })->middleware(Cors::class);

        Route::post('transaction/edit-expense', 'TransactionController@editExpense', function () {
        })->middleware(Cors::class);

        Route::get('transaction/delete-expense/{expense_id}', 'TransactionController@deleteExpense', function () {
        })->middleware(Cors::class);

        Route::post('transaction/all-expense', 'TransactionController@allExpense', function () {
        })->middleware(Cors::class);


        // UPLOAD REPORT
        Route::post('transaction/report', 'TransactionController@uploadReport', function () {
        })->middleware(Cors::class);

        Route::post('transaction', 'TransactionController@fetchTransaction', function () {
        })->middleware(Cors::class);

        Route::get('transaction/delete-transaction/{id}', 'TransactionController@deleteTransaction', function () {
        })->middleware(Cors::class);


        Route::post('transaction/profit', 'TransactionController@uploadProfit', function () {
        })->middleware(Cors::class);

        Route::post('transaction/financial-summary', 'TransactionController@getFinancialSummary', function () {
        })->middleware(Cors::class);

        Route::post('transaction/financial-summary/breakdown', 'TransactionController@getBreakdown', function () {
        })->middleware(Cors::class);



    });

    // =============================================================================
    //               END OF TRANSACTION ROUTE
    // =============================================================================


});
