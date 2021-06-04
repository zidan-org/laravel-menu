<?php

Route::group(['middleware' => config('menu.middleware')], function () {
    //Route::get('wmenuindex', array('uses'=>'\NguyenHuy\Menu\Controllers\MenuController@wmenuindex'));
    $path = rtrim(config('menu.route_path'), '/');
    Route::post($path . '/addCustomMenu', array(
        'as' => 'hAddCustomMenu',
        'uses' => '\NguyenHuy\Menu\Controllers\MenuController@addCustomMenu'
    ));
    Route::post($path . '/deleteItemMenu', array(
        'as' => 'hDeleteItemMenu',
        'uses' => '\NguyenHuy\Menu\Controllers\MenuController@deleteItemMenu'
    ));
    Route::post($path . '/deleteMenug', array(
        'as' => 'hDeleteMenug',
        'uses' => '\NguyenHuy\Menu\Controllers\MenuController@deleteMenug'
    ));
    Route::post($path . '/createNewMenu', array(
        'as' => 'hCreateNewMenu',
        'uses' => '\NguyenHuy\Menu\Controllers\MenuController@createNewMenu'
    ));
    Route::post($path . '/generateMenuControl', array(
        'as' => 'hGenerateMenuControl',
        'uses' => '\NguyenHuy\Menu\Controllers\MenuController@generateMenuControl'
    ));
    Route::post($path . '/updateItem', array(
        'as' => 'hUpdateItem',
        'uses' => '\NguyenHuy\Menu\Controllers\MenuController@updateItem'
    ));
});
