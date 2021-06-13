<?php

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

Route::post('mentor/signup', 'Api\MentorController@signup');
Route::post('mentor/login', 'Api\MentorController@login');

Route::group(['middleware' => 'api.user'], function () {
    Route::get('broadcasts', 'Api\BroadcastController@view');

    # Wallet
    Route::get('wallet', 'Api\WalletController@details');
    Route::post('wallet/deposit', 'Api\WalletController@deposit');
});

Route::group(['middleware' => 'api.mentor'], function () {
    Route::post('broadcast/create', 'Api\BroadcastController@create');
});