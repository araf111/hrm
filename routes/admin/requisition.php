<?php
	Route::resource('/telephone_pabx_approval_steps','TelephoneOrPabxApprovalStepsController');
	Route::resource('/telephone_pabx_rights','TelephonePabxController');
	Route::resource('/office_wise_telephone_pabx','OfficeWiseTelephonePabxController');
	Route::resource('/telephoneExpensesCashAllowance','TelephoneExpenseCashAllowanceController');
	Route::resource('/telephone_pabx_application','TelephonePabxApplicationController');
	Route::post('/getRoom','OfficeWiseTelephonePabxController@getRoom');
	Route::post('/getHostelFloor','TelephonePabxApplicationController@getHostelFloor');
	Route::post('/getHostelBlock','TelephonePabxApplicationController@getHostelBlock');
	Route::post('/getHostelRoom','TelephonePabxApplicationController@getHostelRoom');
	Route::post('/getHouseInfo','TelephonePabxApplicationController@getHouseInfo');
	Route::get('/getBuildingDetailsOfMp','TelephonePabxApplicationController@getBuildingDetailsOfMp');
	// approval process is done by Nasir Uddin
	Route::get('/application-approval','TelephoneOrPabxApprovalStepsController@applicationApproval')->name('application-approval');
	Route::get('/application-approval-deputy','TelephoneOrPabxApprovalStepsController@applicationApprovalDeputySecretary')->name('application-approval-deputy');
	Route::get('/application-approval-deputy-action/{id}','TelephoneOrPabxApprovalStepsController@applicationApprovalDeputyAction')->name('application-approval-deputy-action');
	Route::get('/application-approval-secretary','TelephoneOrPabxApprovalStepsController@applicationApprovalSecretary')->name('application-approval-secretary');
	Route::get('/application-approval-secretary-action/{id}','TelephoneOrPabxApprovalStepsController@applicationApprovalSecretaryAction')->name('application-approval-secretary-action');
    Route::get('/application-approaval-modal','TelephoneOrPabxApprovalStepsController@applicationApproavalForm')->name('application-approaval-modal');
    Route::get('/application-approaval-action','TelephoneOrPabxApprovalStepsController@applicationApproavalFormAction')->name('application-approaval-action');
    Route::get('/mp-id-card-issue','TelephoneOrPabxApprovalStepsController@mpIdCardIssue')->name('mp-id-card-issue');
    Route::get('/issue-approaval-modal','TelephoneOrPabxApprovalStepsController@issueApproavalForm')->name('issue-approaval-modal');
    Route::get('/issue-approaval-action','TelephoneOrPabxApprovalStepsController@issueApproavalActionForm')->name('issue-approaval-action');
    Route::get('/issue-view/{id}','TelephoneOrPabxApprovalStepsController@issueView')->name('issue-view');

	Route::get( 'telephone_pabx/{type}', 'TelephonePabxApplicationController@telephonePabxMenu' );
    Route::get( 'telephone_pabx_list', 'TelephonePabxApplicationController@telephonePabxList' );
	Route::get( 'telephone_pabx_details/{type}/{id}', 'TelephonePabxApplicationController@telephonePabxDetails' );
	Route::post( 'telephone_pabx/setdata', 'TelephonePabxApplicationController@setTelephonePabxData' );
