<?php
    Route::resource('/certificate-application','LCCertificateController');
    Route::resource('/clearance-application', 'ClearanceCertificateController');
    Route::get('/clearance-application-create', 'ClearanceCertificateController@clearanceApplicationCreate')->name('clearance-application-create');

    Route::get('/lc-application-pdf/{id}', 'LCCertificateController@pdfFileLC')->name('lc-application-pdf');
    Route::get('/certificate-service-branch', 'LCCertificateController@certificateServiceBranch')->name('certificate-service-branch');
    Route::get('/certificate-recommendation', 'LCCertificateController@certificateRecommendation')->name('certificate-recommendation');
    Route::get('/certificate-approval', 'LCCertificateController@certificateApproval')->name('certificate-approval');
    Route::get('/certificate-signature', 'LCCertificateController@certificateSignature')->name('certificate-signature');
    Route::get('/service-branch-approaval-modal', 'LCCertificateController@serviceBranchApproavalForm')->name('service-branch-approaval-modal');
    Route::get('/service-branch-action', 'LCCertificateController@serviceBranchAction')->name('service-branch-action');

    Route::get('/certificate-recommendation-approaval-modal', 'LCCertificateController@certificateRecommendationApproavalForm')->name('certificate-recommendation-approaval-modal');
    Route::get('/certificate-recommendation-action', 'LCCertificateController@certificateRecommendationAction')->name('certificate-recommendation-action');

    Route::get('/certificate-approval-modal', 'LCCertificateController@certificateApprovalForm')->name('certificate-approval-modal');
    Route::get('/certificate-approval-action', 'LCCertificateController@certificateApprovalAction')->name('certificate-approval-action');

    Route::get('/certificate-signature-approval-modal', 'LCCertificateController@certificateSignatureForm')->name('certificate-signature-modal');
    Route::get('/certificate-signature-action', 'LCCertificateController@certificateSignatureAction')->name('certificate-signature-action');

    Route::get('/certificate-issue-modal', 'LCCertificateController@certificateIssueForm')->name('certificate-issue-modal');
    Route::get('/certificate-issue-action', 'LCCertificateController@certificateIssueAction')->name('certificate-issue-action');

    Route::get('/lc-certificate-receive-date-check', 'LCCertificateController@lcCertificateReceiveDateCheck')->name('lc-certificate-receive-date-check');

    //ClearanceCertificate Route

    Route::get('/clearance-application-pdf/{id}', 'ClearanceCertificateController@pdfFileClearance')->name('clearance-application-pdf');

    Route::get('/service-branch-clearance-modal', 'ClearanceCertificateController@serviceBranchClearance')->name('service-branch-clearance-modal');
    Route::get('/service-branch-clearance-action', 'ClearanceCertificateController@serviceBranchClearanceAction')->name('service-branch-clearance-action');

    Route::get('/clearance-recommendation-approaval-modal', 'ClearanceCertificateController@clearanceRecommendationApproavalForm')->name('clearance-recommendation-approaval-modal');
    Route::get('/clearance-recommendation-action', 'ClearanceCertificateController@clearanceRecommendationAction')->name('clearance-recommendation-action');

    Route::get('/clearance-approval-modal', 'ClearanceCertificateController@clearanceApproval')->name('clearance-approval-modal');
    Route::get('/clearance-approval-action', 'ClearanceCertificateController@clearanceApprovalAction')->name('clearance-approval-action');

    Route::get('/clearance-signature-modal', 'ClearanceCertificateController@clearanceSignature')->name('clearance-signature-modal');
    Route::get('/clearance-signature-action', 'ClearanceCertificateController@clearanceSignatureAction')->name('clearance-signature-action');

    Route::get('/clearance-issue-modal', 'ClearanceCertificateController@clearanceIssue')->name('clearance-issue-modal');
    Route::get('/clearance-issue-action', 'ClearanceCertificateController@clearanceIssueAction')->name('clearance-issue-action');


