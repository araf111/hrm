<?php

// use App\Http\Controllers\Backend\MasterSetup\CompanyInfoController;

Route::resource('/companyinfos', 'CompanyInfoController');
Route::resource('/ministries', 'MinistryController');
Route::resource('/ministry_wings', 'MinistryWingController');

Route::resource('/constituencies', 'ConstituencyController');

Route::resource('/departments', 'DepartmentController');

Route::resource('/designations', 'DesignationController');

Route::resource('/parliaments', 'ParliamentController');
Route::get('/lastParliament', 'ParliamentController@lastParliament')->name('lastParliament');

Route::resource('/parliament_sessions', 'ParliamentSessionController');

Route::resource('/political_parties', 'PoliticalPartiesController');

Route::resource('/divisions', 'DivisionController');

Route::resource('/districts', 'DistrictController');
Route::get('district/loadData', 'DistrictController@loadData')->name('districts.loadData');

Route::resource('/upazilas', 'UpazilaController');
Route::get('upazila/loadData', 'UpazilaController@loadData')->name('upazilas.loadData');

Route::resource('/unions', 'UnionController');
Route::get('union/loadData', 'UnionController@loadData')->name('unions.loadData');

Route::resource('/songshodBlock', 'SongshodBlockController');
Route::resource('/songshodFloor', 'SongshodFloorController');
Route::resource('/songshodRoom', 'SongshodRoomController');

Route::get('/cabinets', 'CabinetController@index');
Route::get('/cabinet/{ministry_id}/{type}', 'CabinetController@setup_cabinet');
Route::post('/cabinet/save', 'CabinetController@save');
