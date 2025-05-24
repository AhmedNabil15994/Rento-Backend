<?php

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'CategoryController@categories')->middleware('cacheResponse');
    Route::get('/tree', 'CategoryController@tree')->middleware('cacheResponse');
    Route::get('/{id}', 'CategoryController@show')->middleware('cacheResponse');
    Route::get('/{id}/sub-categories', 'CategoryController@listSub')
                        ->name("api.list.sub-categories")
                        ->middleware('cacheResponse');
   
});
