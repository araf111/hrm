<?php
    Route::resource('/proggapon-category','ProggaponCategoryController');
    Route::resource('/proggapons','ProggaponController');
    Route::get('/issue','ProggaponController@issueIdDeleteAjax')->name('issue-attach-delete');
