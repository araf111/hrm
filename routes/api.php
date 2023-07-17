<?php

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

//for reve

Route::get('common_data_list', 'Backend\ProfileActivities\V2ProfileController@commonDataList');
Route::post('applogin', 'SSOLoginController@applogin');

Route::group([
    'namespace' => 'Backend\NoticeManagement'
], function ($router) {
    Route::post('push-from-prp/circular', 'CircularsController@CircularPushFromPRP');
    Route::post('get-from-mp_portal/notice', 'NoticeController@getNoticeListFromMpPortal');
});

Route::group([
    'namespace' => 'Backend\ProfileActivities'
], function ($router) {
    Route::post('allProfiles', 'V2ProfileController@getAllProfile');
});
Route::group([
    'namespace' => 'Backend\ProfileActivities'
], function ($router) {
    Route::post('allProfiles', 'V2ProfileController@getAllProfile');
});

//for mp portal users
Route::group([
    // 'middleware' => 'auth:api',
    'prefix' => 'auth',
    'namespace' => 'Api'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
});

//for Nirbachok Mondoli users
Route::group([
    // 'middleware' => 'auth:api',
    'prefix' => 'nirbachok',
    'namespace' => 'Api'
], function ($router) {
    Route::post('login', 'NirbachokAuthController@login');
    Route::post('logout', 'NirbachokAuthController@logout');
    Route::post('refresh', 'NirbachokAuthController@refresh');
    Route::get('/profile-details/{id}','NirbachokAuthController@selectedUserDetails');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'admin/notice-management',
    'namespace' => 'Backend\NoticeManagement'
], function ($router) {
    Route::resource('notices', 'NoticeController');
    Route::resource('parliament_rules', 'ParliamentRulesController');
    Route::resource('noticestage', 'NoticeStageController');
    Route::get('circulars', 'CircularsController@index');
    Route::post('circulars_list', 'CircularsController@listCircular');
    Route::get('notices/index/{status}', 'NoticeController@index');
    Route::get('notices/notice/priority', 'NoticeController@notice_priority');
    Route::get('notices/notice/notify-ministry/{type?}', 'NoticeController@notify_ministry');
    Route::get('notices/notice/recent-discussion/{type?}', 'NoticeController@recent_discussion');
    Route::get('notices/notice/generate_pdf/{department?}/{type?}', 'NoticeController@create_pdf');
    Route::post('notices/notice/setdata', 'NoticeController@set_notice_data');
    Route::get('discussed', 'NoticeController@discussedNotices');
    Route::get('ministryitem', 'NoticeController@ministryWingList');
    Route::get('notices/notice/speaker', 'NoticeController@speaker_notice');
    Route::get('noticeList', 'NoticeController@allNotices');
    Route::get('filtered_notice', 'NoticeController@filtered_notice');
    Route::get('notice_details/{type}/{id}', 'NoticeController@notice_data');
    Route::post('notices/notice/makelottery', 'NoticeController@make_lottery');
    Route::get('notice_list/{status_id?}', 'NoticeController@notice_list_v2');
    Route::get('notice_list_v2/{status_id?}', 'NoticeController@notice_list_v2');
    Route::post('notices/notice/notice_speech/{id?}', 'NoticeController@notice_speech');
    Route::get('notices/notice/load_speech/', 'NoticeController@load_speech');
});


Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'accommodation-management/mp',
    'namespace' => 'Backend\AccommodationManagement\Mp'
], function ($router) {
  Route::get('applications/list','ApplicationController@list');
  Route::get('applications/pdf/{id}','ApplicationController@pdf');
  Route::resource('applications','ApplicationController');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'hostel-management/mp',
    'namespace' => 'Backend\HostelManagement\Mp'
], function ($router) {
  Route::get('applications/list','ApplicationController@list');
  Route::get('applications/pdf/{id}','ApplicationController@pdf');
  Route::resource('applications','ApplicationController');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'admin/master-setup',
    'namespace' => 'Backend\MasterSetup'
], function ($router) {
    Route::resource('orderofdays', 'OrderOfDaysController');
    Route::post('orderofdays/list_orders', 'OrderOfDaysController@listOrders');
    Route::post('orderofdays/order_action', 'OrderOfDaysController@store');
    Route::get('districtlist', 'AjaxController@districtListByDivisionId');
    Route::get( '/clauseByParliamentBillId', 'AjaxController@clauseByParliamentBillId' );
    Route::get( '/subClauseByParliamentBillId', 'AjaxController@subClauseByParliamentBillId' );
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'mp-leave',
    'namespace' => 'Backend\ProfileActivities\MpLeave'
], function ($router) {
    Route::resource('/leave-application','LeaveApplicationController');
    Route::post('/leave-application-update/{editData}','LeaveApplicationController@updateData');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'parliament',
    'namespace' => 'Backend\MasterSetup'
], function ($router) {
    Route::get('/list','ParliamentController@index');
    Route::get('/parliament_session_list/{parliament_id?}','ParliamentSessionController@getParlimentSession');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'attendance',
    'namespace' => 'Backend\ProfileActivities'
], function ($router) {
    Route::post('list_attendance', 'AttendanceController@listAttendance');
    Route::post('attendance_summary', 'AttendanceController@attendanceSummary');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'mobile-application-management',
    'namespace' => 'Backend\MobileApplicationManagement'
], function ($router) {
    Route::resource('/proggapons','ProggaponController');
    Route::resource('/news','NewsContorller');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'parliament-tv',
    'namespace' => 'Backend\MobileApplicationManagement\ParliamentTv'
], function ($router) {
    Route::resource('tv_list', 'ParliamentTvController');
    Route::post('filter_tv', 'ParliamentTvController@listOfTv');
});


Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'profile-activities',
    'namespace' => 'Backend\ProfileActivities'
], function ($router) {
    Route::get('constituency_list', 'ProfileController@listOfConstituency');
    Route::get('designation_list', 'ProfileController@listOfDesignation');
    Route::get('profile_details/{type}', 'ProfileController@profileDetails');
    Route::post('allProfiles', 'V2ProfileController@getAllProfile');
    Route::get('profile_details_v2/{type}', 'V2ProfileController@profileDetails');
    //Route::post('profile_update', 'ProfileController@updateProfile');
    Route::post('profile_update', 'V2ProfileController@updateData');
    Route::post('profile_list', 'ProfileController@listOfProfile');
    Route::get('persontype', 'MpBookController@personTypeList');
    Route::post('mpnet', 'MpBookController@mpNet');
    Route::post('mycalendar', 'MpBookController@myCalendar');
});


Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'appointment-management',
    'namespace' => 'Backend\AppointmentManagement'
], function ($router) {
    Route::prefix('appointment-request')->name('appointment-request.')->group(function () {
        Route::get('/index', 'AppointmentManage@index')->name('index');
        Route::get('/acceptedList', 'AppointmentManage@acceptedList')->name('acceptedList');
        Route::get('/rejectedList', 'AppointmentManage@rejectedList')->name('rejectedList');
        Route::get('/index/{date}', 'AppointmentManage@index')->name('dateindex');
        Route::get('/acceptedList/{date}', 'AppointmentManage@acceptedList')->name('dateacceptedList');
        Route::get('/rejectedList/{date}', 'AppointmentManage@rejectedList')->name('daterejectedList');

        Route::get('/create', 'AppointmentManage@create')->name('create');
        Route::get('/approved/{id}', 'AppointmentManage@approved')->name('approved');
        Route::get('/declined/{id}', 'AppointmentManage@declined')->name('declined');
        Route::post('/store', 'AppointmentManage@store')->name('store');
        Route::get('{editData}/edit', 'AppointmentManage@edit')->name('edit');
        Route::get('/get_mp_list', 'AppointmentManage@get_mp_list')->name('get_mp_list');
        Route::get('/get_ministry_list', 'AppointmentManage@get_ministry_list')->name('get_ministry_list');
        Route::put('/update/{editData}', 'AppointmentManage@update')->name('update');
        Route::post('/delete', 'AppointmentManage@destroy')->name('delete');
    });

    Route::prefix('appointment-received')->name('appointment-received.')->group(function () {
        Route::get('/index', 'AppointmentManage@receivedIndex')->name('index');
        Route::get('/acceptedList', 'AppointmentManage@receivedAcceptList')->name('acceptedList');
        Route::get('/rejectedList', 'AppointmentManage@receivedRejectList')->name('rejectedList');
        Route::get('/index/{date}', 'AppointmentManage@receivedIndex')->name('dateindex');
        Route::get('/acceptedList/{date}', 'AppointmentManage@receivedAcceptList')->name('dateacceptedList');
        Route::get('/rejectedList/{date}', 'AppointmentManage@receivedRejectList')->name('daterejectedList');
        Route::get('/create', 'AppointmentManage@create')->name('create');
        Route::get('/approved/{id}', 'AppointmentManage@receivedApproved')->name('approved');
        Route::get('/declined/{id}', 'AppointmentManage@receivedDeclined')->name('declined');
        Route::post('/store', 'AppointmentManage@store')->name('store');
        Route::get('{editData}/edit', 'AppointmentManage@edit')->name('edit');
        Route::get('/details_data', 'AppointmentManage@details_data')->name('details_data');
        Route::get('/timechange_data', 'AppointmentManage@timechange_data')->name('timechange_data');
        Route::get('/get_ministry_list', 'AppointmentManage@get_ministry_list')->name('get_ministry_list');
        Route::put('/update/{editData}', 'AppointmentManage@update')->name('update');
        Route::put('/appointment_accept/{editData}', 'AppointmentManage@appointment_accept')->name('appointment_accept');
        Route::put('/appointment_update/{editData}', 'AppointmentManage@appointment_update')->name('appointment_update');
        Route::post('/delete', 'AppointmentManage@destroy')->name('delete');
    });
});
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'app-management',
    'namespace' => 'Backend\AppManagement'
], function ($router) {
    Route::prefix('selected-type')->name('selected-type.')->group(function(){
        Route::get('/index','SelectedTypes@index')->name('index');
        Route::get('/create','SelectedTypes@create')->name('create');
        Route::post('/store','SelectedTypes@store')->name('store');
        Route::get('/edit/{id}','SelectedTypes@edit')->name('edit');
        Route::put('/update/{editData}','SelectedTypes@update')->name('update');
        Route::post('/delete','SelectedTypes@destroy')->name('delete');
    });

    Route::prefix('selected-user')->name('selected-user.')->group(function(){
        Route::get('/index','SelectedUsers@index')->name('index');
        Route::get('/search','SelectedUsers@search')->name('search');
        Route::get('/create','SelectedUsers@create')->name('create');
        Route::post('/store','SelectedUsers@store')->name('store');
        Route::get('/edit/{id}','SelectedUsers@edit')->name('edit');
        Route::put('/update/{editData}','SelectedUsers@update')->name('update');
        Route::post('/delete','SelectedUsers@destroy')->name('delete');
    });
    Route::prefix('selected-member-chat')->name('selected-member-chat.')->group(function(){
        Route::get('/index','SelectedMemberChats@index')->name('index');
        Route::get('/search','SelectedMemberChats@search')->name('search');
        Route::get('/create','SelectedMemberChats@create')->name('create');
        Route::post('/store','SelectedMemberChats@store')->name('store');
        Route::post('/comment_store','SelectedMemberChats@comment_store')->name('comment_store');
        Route::get('/edit/{id}','SelectedMemberChats@edit')->name('edit');
        Route::get('/show/{id}','SelectedMemberChats@show')->name('show');
        Route::get('/member_post_list/{id}','SelectedMemberChats@member_post_list')->name('member_post_list');
	    Route::get('/mp_post_list/{id}','SelectedMemberChats@mp_post_list')->name('mp_post_list');
        Route::put('/update/{editData}','SelectedMemberChats@update')->name('update');
        Route::put('/comment_update/{editData}','SelectedMemberChats@comment_update')->name('comment_update');
        Route::post('/delete','SelectedMemberChats@destroy')->name('delete');
        Route::post('/chat_permision_delete','SelectedMemberChats@chat_permision_destroy')->name('chat_permision_delete');
        Route::post('/comment_delete','SelectedMemberChats@comment_destroy')->name('comment_delete');
    });
    Route::prefix('social-media')->name('social-media.')->group(function(){
        Route::get('index','SocialMedia@index')->name('index');
        Route::get('/create','SocialMedia@create')->name('create');
        Route::post('/store','SocialMedia@store')->name('store');
        Route::get('/edit/{id}','SocialMedia@edit')->name('edit');
        Route::get('/show/{id}','SocialMedia@show')->name('show');
        Route::put('/update/{editData}','SocialMedia@update')->name('update');
        Route::post('/delete','SocialMedia@destroy')->name('delete');
    });
    Route::prefix('digital-support-question')->name('digital-support-question.')->group(function(){
        Route::get('/index','DigitalSupport@index')->name('index');
        Route::get('/create','DigitalSupport@create')->name('create');
        Route::post('/store','DigitalSupport@store')->name('store');
        Route::get('/edit/{id}','DigitalSupport@edit')->name('edit');
        Route::get('/show/{id}','DigitalSupport@show')->name('show');
        Route::put('/update/{editData}','DigitalSupport@update')->name('update');
        Route::post('/delete','DigitalSupport@destroy')->name('delete');
    });
    Route::prefix('digital-support-ans')->name('digital-support-ans.')->group(function(){
        Route::get('/index','DigitalSupport@ans_index')->name('index');
        Route::get('/approve','DigitalSupport@ans_approve_index')->name('approve');
        Route::get('/reject','DigitalSupport@ans_reject_index')->name('reject');
        Route::get('/create','DigitalSupport@create')->name('create');
        Route::post('/store','DigitalSupport@store')->name('store');
        Route::get('/edit/{id}','DigitalSupport@ans_edit')->name('edit');
        Route::get('/show/{id}','DigitalSupport@show')->name('show');
        Route::put('/update/{editData}','DigitalSupport@ans_update')->name('update');
        Route::post('/delete','DigitalSupport@destroy')->name('delete');
    });
    Route::prefix('all-asking-answer')->name('all-asking-answer.')->group(function(){
        Route::get('/index','DigitalSupport@asking_ans_index')->name('index');
        Route::get('/search','DigitalSupport@search_asking_ans_index')->name('search');
    });
    Route::prefix('pole-question')->name('pole-question.')->group(function(){
        Route::get('/index','PullQuestions@index')->name('index');
        Route::get('/create','PullQuestions@create')->name('create');
        Route::post('/store','PullQuestions@store')->name('store');
        Route::get('/edit/{id}','PullQuestions@edit')->name('edit');
        Route::get('/show/{id}','PullQuestions@show')->name('show');
        Route::put('/update/{editData}','PullQuestions@update')->name('update');
        Route::post('/delete','PullQuestions@destroy')->name('delete');
        Route::post('/options_delete','PullQuestions@mcq_destroy')->name('options_delete');
    });

    Route::prefix('pole-list')->name('pole-list.')->group(function(){
        Route::get('/index','PullLists@index')->name('index');
        Route::get('/create','PullLists@create')->name('create');
        Route::post('/store','PullLists@store')->name('store');
        Route::get('/edit/{id}','PullLists@edit')->name('edit');
        Route::get('/show/{id}','PullLists@show')->name('show');
        Route::put('/update/{editData}','PullLists@update')->name('update');
        Route::post('/delete','PullLists@destroy')->name('delete');
        Route::post('/options_delete','PullLists@mcq_destroy')->name('options_delete');
    });
});


Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'profile-activities',
    'namespace' => 'Backend\ProfileActivities'
], function ($router) {
    Route::prefix('mp-leave')->name('mp-leave')->namespace('MpLeave')->group(function () {
        Route::post('/leave-application-update/{editData}', 'LeaveApplicationController@updateData');
        Route::get('/leaveapplication-mpsubmit/{editData}', 'LeaveApplicationController@mpUpdateData');
        Route::resource('/leave-application', 'LeaveApplicationController');
    });
});
/* for nirbachok mondoli login only... */
Route::group([
    'middleware' => 'auth:nirbachok',
], function ($router) {
    Route::prefix('nirbachok/parliament-tv')->group(function(){
        Route::get('tv_list', 'Backend\MobileApplicationManagement\ParliamentTv\ParliamentTvController@index');
    });
    Route::prefix('nirbachok/social-media')->group(function(){
        Route::get('/index','Backend\AppManagement\SocialMedia@index');
    });
    Route::prefix('nirbachok/selected-member-chat')->group(function(){
        Route::get('/index','Backend\AppManagement\SelectedMemberChats@index');
    });

    Route::prefix('nirbachok/mobile-application-management')->group(function(){
        Route::get('/proggapons','Backend\MobileApplicationManagement\ProggaponController@index');
    });

    Route::prefix('nirbachok/orderofday')->group(function(){
        Route::post('/list_orders', 'Backend\MasterSetup\OrderOfDaysController@listOrders');
    });
});

//Travel Allowance API
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'travel-allowance',
    'namespace' => 'Backend\TravelAllowance'
], function ($router) {
    Route::get('/','TravelAllowanceBillController@index')->name('travelAllowanceBill');
    Route::get('/add-new','TravelAllowanceBillController@create')->name('travelAllowanceBill.add');
    Route::post('/add-new','TravelAllowanceBillController@store')->name('travelAllowanceBill.store');
    Route::get('/list', 'TravelAllowanceBillController@index');
    Route::get('/create', 'TravelAllowanceBillController@create');
    Route::post('/store', 'TravelAllowanceBillController@store');
});