<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['preventbackbutton','auth'], 
    'namespace' => 'Leave'], 
    function() {
        Route::group(['prefix' => 'manageHoliday'], function () {
            Route::get('/',['as' => 'holiday.index', 'uses'=>'HolidayController@index']);
            Route::get('/create',['as' => 'holiday.create', 'uses'=>'HolidayController@create']);
            Route::post('/store',['as' => 'holiday.store', 'uses'=>'HolidayController@store']);

            Route::get('/{manageHoliday}/edit',['as'=>'holiday.edit','uses'=>'HolidayController@edit']);
            Route::put('/{manageHoliday}',['as' => 'holiday.update', 'uses'=>'HolidayController@update']);
            Route::delete('/{manageHoliday}/delete',['as'=>'holiday.delete','uses'=>'HolidayController@destroy']);
        });

        Route::group(['prefix' => 'publicHoliday'], function () {
            Route::get('/',['as' => 'publicHoliday.index', 'uses'=>'PublicHolidayController@index']);
            Route::get('/create',['as' => 'publicHoliday.create', 'uses'=>'PublicHolidayController@create']);
            Route::post('/store',['as' => 'publicHoliday.store', 'uses'=>'PublicHolidayController@store']);

            Route::get('/{publicHoliday}/edit',['as'=>'publicHoliday.edit','uses'=>'PublicHolidayController@edit']);
            Route::put('/{publicHoliday}',['as' => 'publicHoliday.update', 'uses'=>'PublicHolidayController@update']);
            Route::delete('/{publicHoliday}/delete',['as'=>'publicHoliday.delete','uses'=>'PublicHolidayController@destroy']);
        });

        Route::group(['prefix' => 'weeklyHoliday'], function () {
            Route::get('/',['as' => 'weeklyHoliday.index', 'uses'=>'WeeklyHolidayController@index']);
            Route::get('/create',['as' => 'weeklyHoliday.create', 'uses'=>'WeeklyHolidayController@create']);
            Route::post('/store',['as' => 'weeklyHoliday.store', 'uses'=>'WeeklyHolidayController@store']);

            Route::get('/{weeklyHoliday}/edit',['as'=>'weeklyHoliday.edit','uses'=>'WeeklyHolidayController@edit']);
            Route::put('/{weeklyHoliday}',['as' => 'weeklyHoliday.update', 'uses'=>'WeeklyHolidayController@update']);
            Route::delete('/{weeklyHoliday}/delete',['as'=>'weeklyHoliday.delete','uses'=>'WeeklyHolidayController@destroy']);
        });

        Route::group(['prefix' => 'leaveType'], function () {
            Route::get('/',['as' => 'leaveType.index', 'uses'=>'LeaveTypeController@index']);
            Route::get('/create',['as' => 'leaveType.create', 'uses'=>'LeaveTypeController@create']);
            Route::post('/store',['as' => 'leaveType.store', 'uses'=>'LeaveTypeController@store']);

            Route::get('/{leaveType}/edit',['as'=>'leaveType.edit','uses'=>'LeaveTypeController@edit']);
            Route::put('/{leaveType}',['as' => 'leaveType.update', 'uses'=>'LeaveTypeController@update']);
            Route::delete('/{leaveType}/delete',['as'=>'leaveType.delete','uses'=>'LeaveTypeController@destroy']);
        });

        Route::group(['prefix' => 'applyForLeave'], function () {
            Route::get('/',['as' => 'applyForLeave.index', 'uses'=>'ApplyForLeaveController@index']);
            Route::get('/create',['as' => 'applyForLeave.create', 'uses'=>'ApplyForLeaveController@create']);
            Route::post('/store',['as' => 'applyForLeave.store', 'uses'=>'ApplyForLeaveController@store']);
            
            Route::post('getEmployeeLeaveBalance','ApplyForLeaveController@getEmployeeLeaveBalance');
            Route::post('applyForTotalNumberOfDays','ApplyForLeaveController@applyForTotalNumberOfDays');
            Route::get(
                '/{applyForLeave}',
                ['as'=>'applyForLeave.show','uses'=>'ApplyForLeaveController@show']
            );
        });

        Route::group(['prefix' => 'earnLeaveConfigure'], function () {
            Route::get('/',['as' => 'earnLeaveConfigure.index', 'uses'=>'EarnLeaveConfigureController@index']);
            Route::post('updateEarnLeaveConfigure','EarnLeaveConfigureController@updateEarnLeaveConfigure');
        });

        Route::group(['prefix' => 'requestedApplication'], function () {
            Route::get('/',['as' => 'requestedApplication.index', 'uses'=>'RequestedApplicationController@index']);
            Route::get(
                '/{requestedApplication}/viewDetails',
                ['as'=>'requestedApplication.viewDetails','uses'=>'RequestedApplicationController@viewDetails']
            );
            Route::put(
                '/{requestedApplication}',
                ['as' => 'requestedApplication.update', 'uses'=>'RequestedApplicationController@update']
            );
        });

        Route::get('leaveReport',['as' => 'leaveReport.leaveReport', 'uses'=>'ReportController@employeeLeaveReport']);
        Route::post('leaveReport',['as' => 'leaveReport.leaveReport', 'uses'=>'ReportController@employeeLeaveReport']);
        Route::get('downloadLeaveReport','ReportController@downloadLeaveReport');

        Route::get('summaryReport',['as' => 'summaryReport.summaryReport', 'uses'=>'ReportController@summaryReport']);
        Route::post('summaryReport',['as' => 'summaryReport.summaryReport', 'uses'=>'ReportController@summaryReport']);
        Route::get('downloadSummaryReport','ReportController@downloadSummaryReport');

        Route::get('myLeaveReport',['as' => 'myLeaveReport.myLeaveReport', 'uses'=>'ReportController@myLeaveReport']);
        Route::post('myLeaveReport',['as' => 'myLeaveReport.myLeaveReport', 'uses'=>'ReportController@myLeaveReport']);
        Route::get('downloadMyLeaveReport','ReportController@downloadMyLeaveReport');

        Route::post('approveOrRejectLeaveApplication','RequestedApplicationController@approveOrRejectLeaveApplication');
});

