<?php
// user
Route::prefix( 'user-info' )->name( 'user-info.' )->group( function () {
    Route::get( '/list', 'UserController@list' )->name( 'list' );
    Route::get( '/add', 'UserController@add' )->name( 'add' );
    Route::post( '/store', 'UserController@store' )->name( 'store' );
    Route::get( '/edit/{id}', 'UserController@edit' )->name( 'edit' );
    Route::get( '/{id}', 'UserController@show' )->name( 'show' );
    Route::post( '/update/{id}', 'UserController@update' )->name( 'update' );
    Route::post( '/delete', 'UserController@destroy' )->name( 'delete' );
    Route::get( '/myprofile', 'UserController@myProfile' )->name( 'myprofile' );
    Route::get('/profile_details/{type}', 'UserController@profileDetails');
    Route::get('/profilelist/{type}', 'UserController@getProfileList');
} );
// role
Route::prefix( 'role-info' )->name( 'role-info.' )->group( function () {
    Route::get( '/list', 'RoleController@list' )->name( 'list' );
    Route::get( '/sorting', 'RoleController@sorting' )->name( 'sorting' );
    Route::get( '/add', 'RoleController@add' )->name( 'add' );
    Route::get( '/duplicate-name-check', 'RoleController@duplicateNameCheck' )->name( 'duplicate-name-check' );
    Route::get( '/duplicate-name_bn-check', 'RoleController@duplicateNameBnCheck' )->name( 'duplicate-name_bn-check' );
    Route::post( '/store', 'RoleController@store' )->name( 'store' );
    Route::get( '/edit/{editData}', 'RoleController@edit' )->name( 'edit' );
    Route::post( '/update/{editData}', 'RoleController@update' )->name( 'update' );
    Route::post( '/delete', 'RoleController@destroy' )->name( 'delete' );
} );

// menu-permission
Route::prefix( 'menu-permission-info' )->name( 'menu-permission-info.' )->group( function () {
    Route::get( '/list', 'MenuPermissionController@list' )->name( 'list' );
    Route::post( '/store', 'MenuPermissionController@store' )->name( 'store' );
} );
