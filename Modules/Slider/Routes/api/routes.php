<?php


Route::group(['prefix' => 'slider'], function () {

    Route::get('/'      , 'SliderController@slider')->name('api.slider.index');

});
