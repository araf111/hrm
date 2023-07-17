<?php


Route::resource('/parliament-tv','ParliamentTv\ParliamentTvController');
//Route::get('/parliament-tv/{parliament-tv}/edit', 'ParliamentTvController');
Route::post('/parliament-tv-update/{editData}','ParliamentTv\ParliamentTvController@update');
Route::resource('/news','NewsContorller');


Route::prefix('setup')->name('setup.')->namespace('Setup')->group(function(){
    Route::resource('/news-categories','NewsCategoriesContrller');

});

Route::prefix('news-categories')->name('news-categories.')->group(function(){
    Route::resource('/news-categories','NewsCategoriesContrller');
});
