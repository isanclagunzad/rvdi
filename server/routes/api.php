<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('authenticate', ['as' => 'api.authenticate', 'uses' => 'Auth\LoginController@loginViaApi']);
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('attendance/bulk-upload', ['as' => 'api.attendance.store.bulk', 'uses' => 'Attendance\UploadAttendanceController@apiStore']);
    Route::namespace('CustomField')->prefix('custom-fields')->group(function () {
        Route::get('/', 'CustomFieldController@index')->name('api.custom-field.index');
        Route::get('{customField}/value/{fieldValue}', 'CustomFieldController@serveFile')
            ->name('api.employee-custom-field.serve-file');
    });

    Route::get('employee/{employee}/custom-fields', 'CustomField\CustomFieldController@listByEmployee')->name('api.employee-custom-field.index');
    Route::post('employee/{employee}/custom-fields', 'CustomField\CustomFieldController@store')->name('api.employee-custom-field.store');
    Route::patch('employee/{employee}/custom-field-value/{customFieldValue}/update', 'CustomField\CustomFieldController@update')
        ->name('api.employee-custom-field-value.update');
    Route::delete('employee/{employee}/custom-field-value/{customFieldValue}/delete', 'CustomField\CustomFieldController@delete')
        ->name('api.employee-custom-field-value.delete');

    Route::post('employee/bulk-upload', ['as' => 'api.employee.store.bulk', 'uses' => 'Employee\BulkUploadController@store']);
    Route::get('employees', ['as' => 'api.employee.list', 'uses' => 'Employee\EmployeeController@apiList']);

    Route::delete('cutoff/{cutOff}', ['as' => 'api.cutoff.delete', 'uses' => 'CutOffController@delete']);
    Route::patch('cutoff/{cutOff}', ['as' => 'api.cutoff.update', 'uses' => 'CutOffController@update']);
    Route::get('cutoff/{cutOff}', ['as' => 'api.cutoff.show', 'uses' => 'CutOffController@show']);
    Route::post('cutoff', ['as' => 'api.cutoff.store', 'uses' => 'CutOffController@store']);
    Route::get('cutoff', ['as' => 'api.cutoff.list', 'uses' => 'CutOffController@index']);
});
