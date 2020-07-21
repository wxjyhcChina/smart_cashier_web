<?php
Route::group([
    'namespace' => 'OuterDevice',
    'middleware' => 'access.routeNeedsPermission:manage-outer-device',
], function() {
    Route::resource('outerDevice', 'OuterDeviceController', ['except' => ['show']]);

    Route::get('outerDevice/get', 'OuterDeviceTableController')->name('outerDevice.get');

    Route::group(['prefix' => 'outerDevice/{outerDevice}'], function() {
        Route::get('mark/{status}', 'CardController@mark')->name('card.mark')->where(['status' => '[0,1]']);
    });
});