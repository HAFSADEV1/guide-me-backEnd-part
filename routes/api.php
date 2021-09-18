<?php

use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\Api\V1\ApiChatController;
use App\Http\Controllers\Api\V1\ApiClientController;
use App\Http\Controllers\Api\V1\ApiCommentController;
use App\Http\Controllers\Api\V1\ApiGuidController;
use App\Http\Controllers\Api\V1\ApiMessagesController;
use App\Http\Controllers\Api\V1\ApiRatingController;
use App\Http\Controllers\Api\V1\ApiReservationController;
use App\Http\Controllers\Api\V1\ApiUserController;
use Illuminate\Auth\Events\Login;
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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('api.v1')->namespace('Api\V1')->group(function () {
    Route::post('/registerGuide', [ApiGuidController::class, 'create']);
    Route::get('/guides/{id?}', [ApiGuidController::class, 'getGuides']);
    Route::get('/guides-unverified', [ApiGuidController::class, 'getUnverifiedGuides']);
    Route::get('/messages/{id}', [ApiChatController::class, 'getMessages']);
    Route::get('/guides-messages/{id}', [ApiChatController::class, 'getGuideMessages']);
    Route::get('/messages/{clientId}/{guideId}/', [ApiChatController::class, 'getMsgWithId']);
    Route::get('/getClientById/{client_id}/', [ApiClientController::class, 'getClientById']);
    Route::get('/getGuideComments/{id}', [ApiGuidController::class, 'getGuideComments']);
    Route::get('/search/{key}', [ApiGuidController::class, 'search']);
    Route::get('/customer-reservations/{client_id}', [ApiReservationController::class, 'getCustomerReservation']);
    Route::get('/get-reservation/{guid_id}', [ApiReservationController::class, 'getReservation']);
    Route::get('/get-reservation/{client_id}/{guid_id}', [ApiReservationController::class, 'getReservationByClient']);
    Route::get('/get-guide-by-ville/{vilee}', [ApiGuidController::class, 'serachByVille']);
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::patch('/update-is_accept-reservation', [ApiReservationController::class, 'updateIsAccept']);
    Route::patch('/update-isValid-guide', [ApiGuidController::class, 'updateIsValid']);
    Route::post('/rate', [ApiRatingController::class, 'create']);
    Route::post('/registerClient', [ApiClientController::class, 'create']);
    Route::post('/sendMessage', [ApiChatController::class, 'sendMessage']);
    Route::post('/comment', [ApiCommentController::class, 'create']);
    Route::post('/reservation', [ApiReservationController::class, 'create']);
});
