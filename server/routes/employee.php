<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['preventbackbutton', 'auth'], 'namespace' => 'Employee'], function () {

    Route::group(['prefix' => 'department'], function () {
        Route::get('/', ['as' => 'department.index', 'uses' => 'DepartmentController@index']);
        Route::get('/create', ['as' => 'department.create', 'uses' => 'DepartmentController@create']);
        Route::post('/store', ['as' => 'department.store', 'uses' => 'DepartmentController@store']);
        Route::get('/{department}/edit', ['as' => 'department.edit', 'uses' => 'DepartmentController@edit']);
        Route::put('/{department}', ['as' => 'department.update', 'uses' => 'DepartmentController@update']);
        Route::delete('/{department}/delete', ['as' => 'department.delete', 'uses' => 'DepartmentController@destroy']);
    });

    Route::group(['prefix' => 'designation'], function () {
        Route::get('/', ['as' => 'designation.index', 'uses' => 'DesignationController@index']);
        Route::get('/create', ['as' => 'designation.create', 'uses' => 'DesignationController@create']);
        Route::post('/store', ['as' => 'designation.store', 'uses' => 'DesignationController@store']);
        Route::get('/{designation}/edit', ['as' => 'designation.edit', 'uses' => 'DesignationController@edit']);
        Route::put('/{designation}', ['as' => 'designation.update', 'uses' => 'DesignationController@update']);
        Route::delete('/{designation}/delete', ['as' => 'designation.delete', 'uses' => 'DesignationController@destroy']);
    });

    Route::group(['prefix' => 'branch'], function () {
        Route::get('/', ['as' => 'branch.index', 'uses' => 'BranchController@index']);
        Route::get('/create', ['as' => 'branch.create', 'uses' => 'BranchController@create']);
        Route::post('/store', ['as' => 'branch.store', 'uses' => 'BranchController@store']);
        Route::get('/{branch}/edit', ['as' => 'branch.edit', 'uses' => 'BranchController@edit']);
        Route::put('/{branch}', ['as' => 'branch.update', 'uses' => 'BranchController@update']);
        Route::delete('/{branch}/delete', ['as' => 'branch.delete', 'uses' => 'BranchController@destroy']);
    });

    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', ['as' => 'employee.index', 'uses' => 'EmployeeController@index']);
        Route::get('/create', ['as' => 'employee.create', 'uses' => 'EmployeeController@create']);
        Route::post('/store', ['as' => 'employee.store', 'uses' => 'EmployeeController@store']);
        Route::get('/custom', ['as' => 'custom.index', 'uses' => 'CustomController@index']);
        Route::get('/custom/manage', ['as' => 'custom.manage', 'uses' => 'CustomController@manage']);
        Route::get('/{employee}/edit', ['as' => 'employee.edit', 'uses' => 'EmployeeController@edit']);
        Route::get('/{employee}', ['as' => 'employee.show', 'uses' => 'EmployeeController@show']);
        Route::put('/{employee}', ['as' => 'employee.update', 'uses' => 'EmployeeController@update']);
        Route::delete('/{employee}/delete', ['as' => 'employee.delete', 'uses' => 'EmployeeController@destroy']);

        Route::get('/bulk-upload/csv', ['as' => 'employee.bulk', 'uses' => 'BulkUploadController@index']);
        Route::post('/bulk-upload/csv', ['as' => 'employee.store.bulk', 'uses' => 'BulkUploadController@store']);
    });

    Route::get('/printEmployee', ['as' => 'employee.print', 'uses' => 'EmployeeController@printEmployee']);

    Route::group(['prefix' => 'warning'], function () {
        Route::get('/', ['as' => 'warning.index', 'uses' => 'WarningController@index']);
        Route::get('/create', ['as' => 'warning.create', 'uses' => 'WarningController@create']);
        Route::post('/store', ['as' => 'warning.store', 'uses' => 'WarningController@store']);
        Route::get('/{warning}/edit', ['as' => 'warning.edit', 'uses' => 'WarningController@edit']);
        Route::get('/{warning}', ['as' => 'warning.show', 'uses' => 'WarningController@show']);
        Route::get('/{warning}', ['as' => 'warning.show', 'uses' => 'WarningController@show']);
        Route::put('/{warning}', ['as' => 'warning.update', 'uses' => 'WarningController@update']);
        Route::delete('/{warning}/delete', ['as' => 'warning.delete', 'uses' => 'WarningController@destroy']);
    });

    Route::group(['prefix' => 'termination'], function () {
        Route::get('/', ['as' => 'termination.index', 'uses' => 'TerminationController@index']);
        Route::get('/create', ['as' => 'termination.create', 'uses' => 'TerminationController@create']);
        Route::post('/store', ['as' => 'termination.store', 'uses' => 'TerminationController@store']);
        Route::get('/{termination}/edit', ['as' => 'termination.edit', 'uses' => 'TerminationController@edit']);
        Route::get('/{termination}', ['as' => 'termination.show', 'uses' => 'TerminationController@show']);
        Route::get('/{termination}', ['as' => 'termination.show', 'uses' => 'TerminationController@show']);
        Route::put('/{termination}', ['as' => 'termination.update', 'uses' => 'TerminationController@update']);
        Route::delete('/{termination}/delete', ['as' => 'termination.delete', 'uses' => 'TerminationController@destroy']);
    });

    Route::group(['prefix' => 'permanent'], function () {
        Route::get('/', ['as' => 'permanent.index', 'uses' => 'EmployeePermanentController@index']);
        Route::get('/updatePermanent', 'EmployeePermanentController@updatePermanent');
    });
});
