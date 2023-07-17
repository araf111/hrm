<?php
/**
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
 */
Route::resource( '/news_tickers', 'NewsTickerController' );
Route::resource( '/sliders', 'SliderController' );
Route::resource( '/mp_messages', 'MpMessageController' );
Route::resource( '/number_counters', 'NumberCounterController' );
Route::resource( '/video_galleries', 'VideoGalleryController' );
Route::resource( '/mobile_apps', 'MobileAppController' );
Route::resource( '/latest_news', 'LatestNewsController' );
Route::resource( '/notice_vertical_menus', 'NoticeVerticalMenuController' );
Route::resource( '/about_sections', 'AboutSectionController' );
Route::resource( '/project_categories', 'ProjectCategoryController' );
Route::resource( '/project_carousels', 'ProjectCarouselController' );
Route::resource( '/bottom_sections', 'BottomSectionController' );


Route::prefix('menu-info')->name('menu-info.')->group(function(){
	Route::get('/view', 'MenuFrontendController@list')->name('list');
	Route::get('/add', 'MenuFrontendController@add')->name('add');
	Route::post('/store', 'MenuFrontendController@store')->name('store');
	Route::post('/sorting','MenuFrontendController@sorting')->name('sorting');
	Route::get('/edit/{id}', 'MenuFrontendController@edit')->name('edit');
	Route::post('/update/{id}', 'MenuFrontendController@update')->name('update');
	Route::get('/get-sub-menu', 'MenuFrontendController@getSubMenuFrontend')->name('getSubMenuFrontend');
});
