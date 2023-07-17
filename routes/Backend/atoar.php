<?php

use App\Http\Controllers\MpOfficeRoomController;

/**
 * All route names are prefixed with 'admin.'.
 * Start Notice Management Group
 */
Route::group( ['middleware' => 'web', 'prefix' => 'notice-management', 'as' => 'notice_management.', 'namespace' => 'NoticeManagement'], function () {
    Route::resource( 'notices', 'NoticeController' );
    Route::resource( 'parliament_rules', 'ParliamentRulesController' );
    Route::resource( 'noticestage', 'NoticeStageController' );
    Route::get( 'circulars', 'CircularsController@index' );
    Route::get( 'session_times', 'CircularsController@sessionTimeList' )->name('session_time.index');
    Route::get( 'session_times/create', 'CircularsController@sessionTimeCreate' )->name('session_time.create');
    Route::post( 'session_times', 'CircularsController@sessionTimeStore' )->name('session_time.store');
    Route::get( 'session_times/{id}/edit', 'CircularsController@sessionTimeEdit' )->name('session_time.edit');
    Route::put( 'session_times/{id}', 'CircularsController@sessionTimeUpdate' )->name('session_time.update');
    Route::delete( 'session_times/{id}', 'CircularsController@sessionTimeDestroy' )->name('session_time.destroy');
    Route::post( 'circulars_list', 'CircularsController@listCircular' );
    Route::get( 'notices/index/{status}', 'NoticeController@index' );
    Route::get( 'notices/notice/priority', 'NoticeController@notice_priority' );
    Route::get( 'notices/notice/notify-ministry/{type?}', 'NoticeController@notify_ministry' );
    Route::get( 'notices/notice/recent-discussion/{type?}', 'NoticeController@recent_discussion' );
    Route::get( 'notices/notice/generate_pdf/{department?}/{type?}', 'NoticeController@create_pdf' );
    Route::get( 'notices/notice/report', 'NoticeController@getReport' );
    Route::get( 'notices/notice/listing', 'NoticeController@getListing' );
    Route::get( 'notices/notice/archive', 'NoticeController@noticeArchive' );
    Route::get( 'notices/notice/report_type/{rule_number}/{session_id?}/{start?}/{end?}', 'NoticeController@getReportTypes' );
    Route::post( 'notices/notice/report', 'NoticeController@generateReport' );
    Route::post( 'notices/notice/listing', 'NoticeController@generateListing' );
    Route::post( 'notices/notice/setdata', 'NoticeController@set_notice_data' );
    Route::get( 'discussed', 'NoticeController@discussedNotices' );
    Route::get( 'ministryitem', 'NoticeController@ministryWingList' );
    Route::get( 'notices/notice/speaker', 'NoticeController@speaker_notice' );
    Route::get( 'noticeList', 'NoticeController@allNotices' );
    Route::get( 'filtered_notice', 'NoticeController@filtered_notice' );
    Route::get( 'notice_details/{type}/{id}', 'NoticeController@notice_data' );
    Route::post( 'notices/notice/makelottery', 'NoticeController@make_lottery' );
    Route::get( 'notice_list/{status_id?}', 'NoticeController@notice_list' );
    Route::post( 'notices/notice/notice_speech/{id?}', 'NoticeController@notice_speech' );
    Route::post( 'notices/notice/notice_dept_task/{id?}', 'NoticeController@noticeDepartmentTask' );
    Route::post( 'notices/notice/review', 'NoticeController@noticeReview' );
    Route::get( 'notices/notice/load_speech/', 'NoticeController@load_speech' );
    Route::get( 'alreadyDiscussed', 'NoticeController@alreadyDiscussed' );
    
    Route::get( 'get_lottery_winners', 'NoticeController@lotteryListing' );
    Route::post( 'lottery_winners', 'NoticeController@lotteryWinners' );
    Route::post( 'lottery_export', 'NoticeController@exportLottery' );

    Route::resource( 'bill_legislations', 'BillAndLegislationController' );
    Route::get( 'bill_legislations/bill_create/{id}', 'BillAndLegislationController@billCreate' )->name( 'billCreate' );
    Route::post( 'bill_legislations/sorting', 'BillAndLegislationController@sorting' )->name( 'bill_legislations.sorting' );
    //Route::get( 'bill_legislations/subclause', 'BillAndLegislationController@subClauseList' )->name( 'subclause' );
    Route::post( 'bill_legislations/subclause', 'BillAndLegislationController@subClauseList' )->name( 'subclause' );

    Route::resource( 'bill_legislation_titles', 'BillAndLegislationTitleController' );
    Route::get( 'bill_legislation_titles/sorting', 'BillAndLegislationTitleController@sorting' )->name( 'bill_legislation_titles.sorting' );
    Route::get( 'bill_legislation_titles/duplicate-name-check', 'BillAndLegislationTitleController@duplicateNameCheck' )->name( 'bill_legislation_titles.duplicate-name-check' );
    Route::get( 'bill_legislation_titles/duplicate-name_bn-check', 'BillAndLegislationTitleController@duplicateNameBnCheck' )->name( 'bill_legislation_titles.duplicate-name_bn-check' );

    Route::get( 'speakerindep', 'NoticeController@speakerActionInDepartment' );

    Route::get( 'submission_last_time', 'NoticeController@noticeSubmissionLastTime' );
} );
/**
 * All route names are prefixed with 'admin.'.
 * Start Master Setup Group
 */
Route::group( ['prefix' => 'master-setup', 'as' => 'master_setup.', 'namespace' => 'MasterSetup'], function () {
    Route::resource( 'standing_committees', 'StandingCommitteeController' );
    Route::resource( 'assessment_committees', 'AssessmentCommitteeController' );
    Route::resource( 'committee_designation', 'CommitteeDesignationController' );
    Route::resource( 'new_standing_committees', 'NewStandingCommitteeController' );
    Route::resource( 'mp_office_room', 'MpOfficeRoomController' );
    Route::post( 'mp_office_room/deletebyroom', 'MpOfficeRoomController@deleteByRoomID');
    Route::get('search_form', 'MpOfficeRoomController@Search_form');
    Route::post('mp_office_room_search','MpOfficeRoomController@mpOfficeRoomSearch');
    Route::get( 'mp_office_room_report', 'MpOfficeRoomController@getReport');
    Route::post( 'mp_office_room_report', 'MpOfficeRoomController@generateReport');
    // Route::get( 'notices/notice/report', 'NoticeController@getReport' );
    Route::post('allotedRoom/{room_id}','MpOfficeRoomController@roomExist');
    Route::post('pdfFileDownload/{id}','MpOfficeRoomController@pdfFileDownload');
    Route::resource( 'committee_room', 'CommitteeRoomController');
    Route::get('committee_room/{type}/{block}/{floor?}/{room?}', 'CommitteeRoomController@getItems');
    Route::resource( 'committee_meeting', 'CommitteeMeetingController');
    Route::get('committee_meeting/{from_date}/{to_date?}', 'CommitteeMeetingController@getMeetingList');
    Route::post('list_attendance', 'CommitteeMeetingController@listAttendance');
    Route::post('attendance_summary', 'CommitteeMeetingController@attendanceSummary');

    Route::resource( 'orderofdays', 'OrderOfDaysController' );
    Route::post( 'orderofdays/list_orders', 'OrderOfDaysController@listOrders' );
    Route::post( 'orderofdays/order_action', 'OrderOfDaysController@store' );
} );

Route::group( ['prefix' => 'profile-activities', 'as' => 'profile-activities.', 'namespace' => 'ProfileActivities'], function () {
    // Route::resource('mpbooks','MpBookController');
    Route::resource( 'appointments', 'AppointmentController' );
    Route::get( 'appointments/approved/{id}', 'AppointmentController@approved' );
    Route::get( 'appointments/declined/{id}', 'AppointmentController@declined' );
} );

Route::group( ['prefix' => 'petition-management', 'as' => 'petition_management', 'namespace' => 'PetitionManagement'], function () {
    Route::get( 'petition/{type}', 'PetitionController@petitionMenu' );
    Route::get( 'petition_list', 'PetitionController@petitionList' );
    Route::get( 'petition_mp', 'PetitionController@petitionInMp' );
    Route::get( 'petition_in_committee', 'PetitionController@petitionInCommittee' );
    Route::get( 'petition_list_speaker', 'PetitionController@petitionSpeakerList' );
    Route::get( 'petition_waiting_list', 'PetitionController@petitionWaitingList' );
    Route::post( 'setdata', 'PetitionController@setPetitionData' );
    Route::post( 'explanation', 'PetitionController@setExplanationData' );
    Route::get( 'petition_details/{type}/{id}', 'PetitionController@petitionDetails' );
    Route::get( 'report', 'PetitionController@getReport' );
    Route::post( 'report', 'PetitionController@generateReport' );
} );
