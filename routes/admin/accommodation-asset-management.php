<?php


Route::prefix('setup')->name('setup.')->namespace('Setup')->group(function(){
  
    Route::resource('accommodation_assets', 'AccommodationAssetController');
    Route::resource('furniture_electronic_goods', 'FurnitureElectronicGoodController');
    
    Route::post('furniture-electronic-goods', 'FurnitureElectronicGoodController@findTotal')->name('furniture-electronic-goods.find-total');
    Route::resource('accommodation-asset-package', 'AccommodationAssetPackageController');
    Route::resource('accommodation_asset_allotment', 'AccommodationAssetPackageAllotmentController');
    Route::get('/application-approval','AccommodationAssetPackageAllotmentController@applicationApproval')->name('application-approval');
    Route::get('/application-approaval-modal','AccommodationAssetPackageAllotmentController@applicationApproavalForm')->name('application-approaval-modal');
    Route::get('/application-approaval-action','AccommodationAssetPackageAllotmentController@applicationApproavalFormAction')->name('application-approaval-action');

   

});