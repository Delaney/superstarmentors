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

Route::post('user/signup', 'Api\UserController@signup');
Route::post('user/login', 'Api\UserController@login');

Route::group(['middleware' => 'api.user'], function () {
    Route::get('following', 'Api\FollowController@following');
    Route::post('follow', 'Api\FollowController@follow');
    Route::post('unfollow', 'Api\FollowController@unfollow');

    Route::get('broadcasts', 'Api\BroadcastController@view');
    Route::get('broadcasts/user', 'Api\BroadcastController@view_subscribed');
    Route::post('broadcasts/subscribe', 'Api\BroadcastController@subscribe');
    Route::post('broadcasts/cancel', 'Api\BroadcastController@user_cancel');

    # Wallet
    Route::get('wallet', 'Api\WalletController@details');
    Route::post('wallet/deposit', 'Api\WalletController@deposit');
});

Route::group(['middleware' => 'api.mentor'], function () {
    Route::post('broadcast/create', 'Api\BroadcastController@create');
});