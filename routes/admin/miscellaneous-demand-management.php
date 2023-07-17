<?php

Route::prefix('no-objection-certificate')->name('no-objection-certificate.')->namespace('NoObjectionCertificate')->group(function(){
    Route::get('/all-dept-lists/{id}','NoObjectionCertificateController@getDeptList');
    Route::get('/application-download/{id}','NoObjectionCertificateController@downloadNoc');
    Route::resource('/certificate-application','NoObjectionCertificateController');

    Route::get('/dept-lists/{id}','NocVerificationController@getDeptList')->name('getDeptList');
    Route::get('/noc-verification','NocVerificationController@nocCheckSubmit')->name('verification');;
    Route::resource('/certificate-verification','NocVerificationController');

    Route::get('/noc-approval','NocApprovalController@nocCheckSubmit')->name('noc-approval');
    Route::resource('/certificate-approval','NocApprovalController');

    Route::get('/noc-issue','NocCertificateIssueController@nocCheckSubmit')->name('noc-issue');
    Route::resource('/certificate-issue','NocCertificateIssueController');
    Route::resource('all-certificate-list', 'NocAllCertificateListController', ['names' => 'all_noc']);

});