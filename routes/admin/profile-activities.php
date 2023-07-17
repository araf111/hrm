<?php
Route::resource('/profiles', 'ProfileController');
Route::resource('/v2profiles', 'V2ProfileController');
Route::post('/updateprofile', 'V2ProfileController@updateData');
Route::post('/storeProfile', 'V2ProfileController@store');
Route::resource('/file-category', 'FileCategoryController');
Route::resource('/file-info', 'FileInfoController');
Route::get('/view-file/{id}', 'FileInfoControlle@singleFileView')->name('single-file-view');
Route::post('/profiledoc/{all?}', 'V2ProfileController@generateDoc');
Route::get('/file-delete', 'FileInfoController@fileDeleteAction')->name('file-delete');
Route::post('/loadprofile', 'V2ProfileController@loadProfile');
//Route::post('/loadAllprofiles','V2ProfileController@loadAllProfiles');
Route::post('/loadAllprofiles', 'V2ProfileController@crossCheck');
Route::post('/profileImage', 'V2ProfileController@imageConversion');
Route::post('/saveProfile', 'ProfileController@updateV2Profile');
Route::get('/profile_details/{type}', 'V2ProfileController@profileDetails');
Route::get('/myprofile', 'V2ProfileController@myProfile');

Route::get('/file-share/{share_id}', 'FileShareController@singleFileShare')->name('file-share');
Route::get('/share-info-entry/{id}', 'FileShareController@shareInfoEntry')->name('share-info-entry');
Route::delete('/share-info-delete/{shareId}', 'FileShareController@shareInfoDelete')->name('share-info-delete');

Route::resource('/mpbooks', 'MpBookController');
Route::post('/listmp/{type}', 'MpBookController@showMpBook');
Route::post('mycalendar', 'MpBookController@myCalendar');

// menu-permission
Route::prefix('mpBook-info')->name('mpBook-info.')->group(function () {
    Route::get('/index', 'MpBookController@index')->name('index');
    Route::post('/show', 'MpBookController@show')->name('show');
});

Route::prefix('mp-leave')->name('mp-leave.')->namespace('MpLeave')->group(function () {
    Route::resource('/leave-application', 'LeaveApplicationController');
    Route::post('/leave-application-update/{editData}', 'LeaveApplicationController@updateData');
    Route::get('/leaveapplication-mpsubmit/{editData}', 'LeaveApplicationController@mpUpdateData');
});

Route::prefix('leave-submit')->name('leave-submit.')->namespace('MpLeave')->group(function () {
    Route::resource('/leave-approval', 'HolidayApprovalController');
    Route::get('/reject-show-data/{id}', 'HolidayApprovalController@showRejectData');
    Route::get('/approve-show-data/{id}', 'HolidayApprovalController@showApproveData');
    Route::get('/leave-approval-submit', 'HolidayApprovalController@approvalSubmit');
});
