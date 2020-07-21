<?php
/**
 * Created by PhpStorm.
 * User: billy
 * Date: 05/09/2017
 * Time: 1:47 PM
 */
Route::group([
    'namespace' => 'Restaurant',
    'middleware' => 'access.routeNeedsPermission:manage-restaurant',
], function() {
    Route::resource('restaurant', 'RestaurantController', ['except' => ['show']]);

    Route::get('restaurant/get', 'RestaurantTableController')->name('restaurant.get');
    Route::get('restaurant/getCards', 'RestaurantTableController@getCards')->name('restaurant.getCards');
    Route::get('restaurant/getDevices', 'RestaurantTableController@getDevices')->name('restaurant.getDevices');
    Route::post('restaurant/uploadImage', 'RestaurantController@uploadImage')->name('restaurant.uploadImage');

    Route::group(['prefix' => 'restaurant/{restaurant}'], function() {
        Route::get('mark/{status}', 'RestaurantController@mark')->name('restaurant.mark')->where(['status' => '[0,1]']);
        Route::get('info', 'RestaurantController@show')->name('restaurant.info');

        Route::get('accounts', 'RestaurantController@accounts')->name('restaurant.accounts');
        Route::get('accounts/get', 'RestaurantTableController@getAccounts')->name('restaurant.getAccounts');
        Route::get('accounts/{account}/password/change', 'RestaurantController@change_password')->name('restaurant.change-password');
        Route::patch('accounts/{account}/password/change', 'RestaurantController@change_password_store')->name('restaurant.change-password.post');

        Route::get('shops', 'RestaurantController@shops')->name('restaurant.shops');
        Route::get('shops/get', 'RestaurantTableController@getShops')->name('restaurant.getShops');

        Route::get('cards/create', 'RestaurantController@assignCard')->name('restaurant.assignCard');
        Route::post('cards/store', 'RestaurantController@assignCardStore')->name('restaurant.assignCardStore');

        Route::get('devices/create', 'RestaurantController@assignDevice')->name('restaurant.assignDevice');
        Route::post('devices/store', 'RestaurantController@assignDeviceStore')->name('restaurant.assignDeviceStore');

        Route::get('restaurant/consumeOrder', 'RestaurantController@consumeOrder')->name('restaurant.consumeOrder');
        Route::get('restaurant/getConsumeOrder', 'RestaurantController@getConsumeOrder')->name('restaurant.getConsumeOrder');
        Route::get('restaurant/getConsumeOrderStatistics', 'RestaurantController@getConsumeOrderStatistics')->name('restaurant.getConsumeOrderStatistics');
        Route::post('restaurant/consumeOrderExport', 'RestaurantController@consumeOrderExport')->name('restaurant.consumeOrderExport');

        Route::get('restaurant/rechargeOrder', 'RestaurantController@rechargeOrder')->name('restaurant.rechargeOrder');
        Route::get('restaurant/getRechargeOrder', 'RestaurantController@getRechargeOrder')->name('restaurant.getRechargeOrder');
        Route::get('restaurant/getRechargeOrderStatistics', 'RestaurantController@getRechargeOrderStatistics')->name('restaurant.getRechargeOrderStatistics');
        Route::post('restaurant/rechargeOrderExport', 'RestaurantController@rechargeOrderExport')->name('restaurant.rechargeOrderExport');
    });
});