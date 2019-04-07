<?php
Route::get('/', 'PagesController@index')->name('login');
Route::group(['prefix' => 'manage', 'as' => 'manage.'], function()
{
    Route::get('', 'PagesController@manage')->name('index');
    Route::post('vacation', 'PagesController@vacation')->name('vacation');
    Route::post('update', 'PagesController@updateVacation')->name('updatevacation');
});

Route::post('auth/{action}/{userId?}', 'PagesController@auth')->name('auth');
