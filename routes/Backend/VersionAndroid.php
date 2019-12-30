<?php
/**
 * Created by PhpStorm.
 * User: billy
 * Date: 05/09/2017
 * Time: 1:47 PM
 */

Route::group([
    'namespace'  => 'VersionAndroid',
    'middleware' => 'access.routeNeedsPermission:manage-version-android',
], function() {
    Route::resource('versionAndroid', 'VersionAndroidController', ['except' => ['show']]);

    Route::get('versionAndroid/get', 'VersionAndroidTableController')->name('versionAndroid.get');

    Route::group(['prefix' => 'versionAndroid/{versionAndroid}'], function() {

    });
});