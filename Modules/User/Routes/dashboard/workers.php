<?php

Route::group(['prefix' => 'workers'], function () {

  	Route::get('/' ,'WorkerController@index')
  	->name('dashboard.workers.index')
    ->middleware(['permission:show_workers']);

  	Route::get('datatable'	,'WorkerController@datatable')
  	->name('dashboard.workers.datatable')
  	->middleware(['permission:show_workers']);

  	Route::get('create'		,'WorkerController@create')
  	->name('dashboard.workers.create')
    ->middleware(['permission:add_workers']);

  	Route::post('/'			,'WorkerController@store')
  	->name('dashboard.workers.store')
    ->middleware(['permission:add_workers']);

  	Route::get('{id}/edit'	,'WorkerController@edit')
  	->name('dashboard.workers.edit')
    ->middleware(['permission:edit_workers']);

  	Route::put('{id}'		,'WorkerController@update')
  	->name('dashboard.workers.update')
    ->middleware(['permission:edit_workers']);

  	Route::delete('{id}'	,'WorkerController@destroy')
  	->name('dashboard.workers.destroy')
    ->middleware(['permission:delete_workers']);

  	Route::get('deletes'	,'WorkerController@deletes')
  	->name('dashboard.workers.deletes')
    ->middleware(['permission:delete_workers']);

  	Route::get('{id}','WorkerController@show')
  	->name('dashboard.workers.show')
    ->middleware(['permission:show_workers']);

});
