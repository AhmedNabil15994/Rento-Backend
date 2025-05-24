<?php
// addations
Route::group(['prefix' => 'offers'], function () {
    Route::get('/', 'OfferController@index')->middleware('cacheResponse');
    Route::get('/{id}', 'OfferController@view');
});
