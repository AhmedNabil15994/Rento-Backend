<?php

Route::group(['prefix' => 'advertisements'], function () {

    Route::get('/'      , 'AdvertisementController@index');

});
