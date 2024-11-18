<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

// front page route

Route::get('/', 'Front\WebController@index');
Route::get('job/{id}/{slug?}', 'Front\WebController@jobDetails')->name('job.details');
Route::post('job-application', 'Front\WebController@jobApply')->name('job.application');

// front page route

Route::get('login', 'User\LoginController@index');
Route::post('login', 'User\LoginController@Auth');

Route::get('mail', 'User\HomeController@mail');

Route::group(['middleware' => ['preventbackbutton', 'auth']], function () {

    Route::get('dashboard', 'User\HomeController@index');
    Route::get('profile', 'User\HomeController@profile');
    Route::get('logout', 'User\LoginController@logout');

    Route::resource('user', 'User\UserController', ['parameters' => ['user' => 'user_id']]);

    Route::get('importEmployees', 'User\ImportEmployeesController@index')->name('importEmployees.index');
    Route::post('importViaCSV', ['as' => 'import.employees', 'uses' => 'Employee\BulkUploadController@store']);
    Route::get('importBiometrics', 'User\ImportBiometricsController@index')->name('importBiometrics.index');

    Route::resource('userRole', 'User\RoleController', ['parameters' => ['userRole' => 'role_id']]);
    Route::resource('rolePermission', 'User\RolePermissionController', ['parameters' => ['rolePermission' => 'id']]);
    Route::post('rolePermission/get_all_menu', 'User\RolePermissionController@getAllMenu');
    Route::resource('changePassword', 'User\ChangePasswordController', ['parameters' => ['changePassword' => 'id']]);

    Route::get('filters', 'FilterController@index')->name('filters.index');
});

Route::get('local/{language}', function ($language) {
    session(['my_locale' => $language]);
    return redirect()->back();
});

Route::get('/static/{path}', 'ReactController@redirectStatic')->where('path', '.*');
