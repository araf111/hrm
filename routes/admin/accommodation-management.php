<?php
Route::prefix('setup')->name('setup.')->namespace('Setup')->group(function(){
  Route::resource('accommodation-approval-step','AccommodationApprovalStepController');
  Route::get('/areas/duplicate-check','AreaController@duplicateDataCheck')->name('areas.duplicate-check');
  Route::get('/accommodationbuildings/duplicate-check','AccommodationBuildingController@duplicateDataCheck')->name('accommodationbuildings.duplicate-check');
  Route::get('/housebuildings/duplicate-check','HouseBuildingController@duplicateDataCheck')->name('housebuildings.duplicate-check');
  Route::get('/flat_types/duplicate-check','FlatTypeController@duplicateDataCheck')->name('flat_types.duplicate-check');
  Route::resource('areas','AreaController');
  Route::resource('accommodationbuildings','AccommodationBuildingController');
  Route::resource('housebuildings','HouseBuildingController');
  Route::resource('flat_types', 'FlatTypeController');
  Route::resource('floorflats','FloorFlatController');
  Route::get('/flats','FlatController@index')->name('flats.index');
  Route::get('/flats/type/create','FlatController@create')->name('flats.type-setup');
  Route::post('/flats/type/store','FlatController@store')->name('flats.type-store');
  Route::get('/flats/{id}/edit','FlatController@edit')->name('flats.edit');
  Route::put('/flats/type/update/{id}','FlatController@update')->name('flats.type-update');
  Route::delete('/flats/{id}','FlatController@destroy')->name('flats.destroy');
  Route::resource('application_types','AccommodationApplicationTypeController');
  Route::resource('hostel_buildings','HostelBuildingController');
  Route::resource('hostel_floors','HostelFloorController');
  Route::resource('office_rooms','OfficeRoomController');
  Route::resource('office_room_types','OfficeRoomTypeController');
  Route::resource('office','OfficeController');
  Route::resource('hostel_application_types', 'HostelApplicationTypeController');
});

Route::prefix('mp')->name('mp.')->namespace('Mp')->group(function(){
  Route::get('applications/list','ApplicationController@list')->name('applications.list');
  Route::get('applications/pdf_approval/{id}','ApplicationController@pdf_approval')->name('applications.pdf_approval');
  Route::get('applications/pdf_aggrement/{id}','ApplicationController@pdf_aggrement')->name('applications.pdf_aggrement');
  Route::get('applications/pdf/{id}','ApplicationController@pdf')->name('applications.pdf');
  Route::resource('applications','ApplicationController');

  Route::get('create_page/{application_type}/{flat_type?}/{building_id?}/{area_id?}','ApplicationController@createPage')->name('applications.createPage');

  //Asset Requisition 
  Route::get('asset-requisition','AssetRequisitionController@index')->name('asset-requisition');
  Route::get('create-asset-requisition/{type}','AssetRequisitionController@assetRequisition');
  Route::get('requisition-details/{type}','AssetRequisitionController@requisitionDetails');
  Route::get('requisition-update/{id}','AssetRequisitionController@requisitionUpdate');
  Route::get('allotment-asset-details/{accommodation_type}/{flat_type}','AssetRequisitionController@assetPackageDetails');
  Route::post('save-requisition','AssetRequisitionController@saveRequisition');
});

Route::prefix('department')->name('department.')->namespace('Department')->group(function(){
  Route::get('applications-monitoring/ajax-data','ApplicationMonitoringController@ajaxData')->name('applications-monitoring.ajax-data');
  Route::get('applications-monitoring/approve','ApplicationMonitoringController@approve')->name('applications-monitoring.approve');
  Route::get('applications-monitoring/reject','ApplicationMonitoringController@reject')->name('applications-monitoring.reject');
  Route::get('applications-monitoring/building-list-by-area','ApplicationMonitoringController@buildingListByArea')->name('applications-monitoring.building-list-by-area');
  Route::post('applications-monitoring/flat-list-by-building','ApplicationMonitoringController@flatListByBuilding')->name('applications-monitoring.flat-list-by-building');
  Route::resource('applications-monitoring','ApplicationMonitoringController');

  //asset allotment module
  Route::get('asset-allocation','AssetAllocationController@index')->name('asset-allocation');
  Route::get('allotment-application-details/{type}','AssetAllocationController@applicationDetails');
  Route::get('allotment-asset-details/{accommodation_type}/{flat_type}','AssetAllocationController@assetPackageDetails');
  Route::get('allotment-details/{application_id}','AssetAllocationController@allotmentDetails');
  Route::post('save-package-allocation','AssetAllocationController@savePackageAllotment');

  //asset requisition module
  Route::get('asset-requisition','RequisitionMonitoringController@index');
  Route::get('requisition-application-details/{type}','RequisitionMonitoringController@applicationDetails');
});