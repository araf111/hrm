<?php
Route::prefix('setup')->name('setup.')->namespace('Setup')->group(function(){
 Route::resource('hostel_application_types', 'HostelApplicationTypeController');
 Route::resource('hostel-approval-step','HostelApprovalStepController');
 Route::resource('hostel_buildings','HostelBuildingController');
 Route::get('/offices/get-ajax-room','OfficeController@getAjaxRoom')->name('offices.get-ajax-room');
 Route::resource('offices','OfficeController');
 Route::resource('office_rooms','OfficeRoomController');
 Route::resource('office_room_types','OfficeRoomTypeController');
});

Route::prefix('mp')->name('mp.')->namespace('Mp')->group(function(){
  Route::get('applications/list','ApplicationController@list')->name('applications.list');
  Route::get('applications/pdf/{id}','ApplicationController@pdf')->name('applications.pdf');
  Route::get('applications/pdf_approval/{id}','ApplicationController@pdf_approval')->name('applications.pdf_approval');
  Route::get('applications/pdf_aggrement/{id}','ApplicationController@pdf_aggrement')->name('applications.pdf_aggrement');
  Route::resource('applications','ApplicationController');
  Route::get('create_page/{application_type}/{office_room_type?}/{hostel_building_id?}','ApplicationController@createPage')->name('applications.createPage');
});

Route::prefix('department')->name('department.')->namespace('Department')->group(function(){
  Route::get('applications-monitoring/ajax-data','ApplicationMonitoringController@ajaxData')->name('applications-monitoring.ajax-data');
  Route::get('applications-monitoring/approve','ApplicationMonitoringController@approve')->name('applications-monitoring.approve');
  Route::get('applications-monitoring/reject','ApplicationMonitoringController@reject')->name('applications-monitoring.reject');
  Route::post('applications-monitoring/office-list-by-building','ApplicationMonitoringController@officeListByBuilding')->name('applications-monitoring.office-list-by-building');
  Route::resource('applications-monitoring','ApplicationMonitoringController');

  //asset allotment module
  Route::get('asset-allocation','AssetAllocationController@index')->name('asset-allocation');
  Route::get('test-approval','AssetAllocationController@testApprove');
  Route::get('allotment-application-details/{type}','AssetAllocationController@applicationDetails');
  Route::get('allotment-asset-details/{accommodation_type}','AssetAllocationController@assetPackageDetails');
  Route::get('allotment-details/{requisition_id}','AssetAllocationController@allotmentDetails');
  Route::post('save-package-allocation','AssetAllocationController@savePackageAllotment');
});