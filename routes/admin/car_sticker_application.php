<?php
    Route::resource('/application','CarStickerApplicationController');
    Route::get('/application-pdf/{id}','CarStickerApplicationController@pdfFileDownload')->name('application-pdf');
    Route::get('/sticker-serial-pdf/{id}','CarStickerApplicationController@pdfCarSerialDownload')->name('sticker-serial-pdf');
    Route::get('/application-approval','CarStickerApplicationController@applicationApproval')->name('application-approval');
    Route::get('/application-approaval-modal','CarStickerApplicationController@applicationApproavalForm')->name('application-approaval-modal');
    Route::get('/application-approaval-action','CarStickerApplicationController@applicationApproavalFormAction')->name('application-approaval-action');
    Route::get('/car-sticker-issue','CarStickerApplicationController@carStickerIssue')->name('car-sticker-issue');
    Route::get('/carStickerExistingNumber','CarStickerApplicationController@carStickerExistingNumber')->name('carStickerExistingNumber');
    Route::get('/issue-approaval-modal','CarStickerApplicationController@issueApproavalForm')->name('issue-approaval-modal');
    Route::get('/issue-approaval-action','CarStickerApplicationController@issueApproavalActionForm')->name('issue-approaval-action');

    Route::get('/issue-view/{id}','CarStickerApplicationController@issueView')->name('issue-view');