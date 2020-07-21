<?php
Route::group([
    'namespace' => 'Shop',
    'middleware' => 'access.routeNeedsPermission:manage-shop',
], function() {
    Route::resource('shop', 'ShopController', ['except' => ['show']]);

    Route::get('shop/get', 'ShopTableController')->name('shop.get');

    Route::get('shop/getDevices', 'ShopTableController@getOuterDevices')->name('shop.getDevices');

    Route::group([
        'prefix' => 'shop/{shop}',
    ], function() {
        Route::get('edit', 'ShopController@edit')->name('shop.edit');
        Route::get('mark/{status}', 'ShopController@mark')->name('shop.mark')->where(['status' => '[0,1]']);

        Route::get('devices/create', 'ShopController@assignDevice')->name('shop.assignDevice');
        Route::post('devices/store', 'ShopController@assignDeviceStore')->name('shop.assignDeviceStore');
    });
});