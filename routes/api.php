<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register-user', 'UserApiController@register_user')->name('register-user');
Route::post('login-user', 'UserApiController@login_user')->name('login-user');
Route::get('token-check', 'UserApiController@token_check')->name('token-check');

Route::middleware('auth:api')->group(function () {
    Route::any('home-api', 'UserApiController@home_api')->name('home-api');
    Route::get('get-all-company-unit', 'UserApiController@get_client_company_unit')->name('get-all-company');
    Route::post('edit-company-unit/{company_unit}', 'UserApiController@edit_client_company_unit')->name('edit-company-unit');
    Route::get('get-all-company-with-unit', 'UserApiController@get_client_company_with_unit')->name('get-all-company-with-unit');
    Route::get('profile-user', 'UserApiController@profile_user')->name('profile-user');
    Route::get('get-all-branch', 'UserApiController@get_all_branch')->name('get-all-branch');
    Route::post('edit-branch/{branch}', 'UserApiController@edit_branch')->name('edit-branch');
    Route::post('get-company-by-branch-id', 'UserApiController@get_company_by_branch_id')->name('get-company-by-branch-id');
    Route::post('get-company-unit-by-company-id', 'UserApiController@get_company_unit_by_company_id')->name('get-company-unit-by-company-id');
    Route::get('get-all-area-rounder', 'UserApiController@get_all_area_rounder')->name('get-all-area-rounder');
    Route::post('create-area-rounder', 'UserApiController@create_area_rounder');
    Route::post('edit-area-rounder', 'UserApiController@edit_area_rounder');

    //From Public
    Route::get('emp-field', 'UserApiController@get_emp_field')->name('emp-field');
    Route::post('add-emp', 'UserApiController@add_employee')->name('add-emp');
    Route::get('get-all-department', 'UserApiController@get_all_department')->name('get-all-department');
    Route::post('get-department-by-id', 'UserApiController@get_department_by_id')->name('get-department-by-id');
    Route::get('get-all-designation', 'UserApiController@get_all_designation')->name('get-all-designation');
    Route::get('get-all-company', 'UserApiController@get_client_company')->name('get-all-company'); //
    Route::post('edit-client-company/{company}', 'UserApiController@edit_client_company')->name('edit-client-company'); //
    Route::post('get-company-by-id', 'UserApiController@get_company_by_id')->name('get-company-by-id');

    Route::post('user-status/{id}', 'UserApiController@user_status');

    Route::get('emp-field-new', 'UserApiController@get_emp_field_2')->name('emp-field-new');
    Route::post('add-emp-static', 'UserApiController@add_employee_static')->name('add-emp-static');
    Route::post('aadhar-check', 'UserApiController@aadhar_check')->name('aadhar-check');

    Route::post('add-emp-new', 'UserApiController@add_employee_new')->name('add-emp-new');
    Route::get('get-all-emp-role', 'EmpRoleController@get_all_emp_role')->name('get-all-emp-role');
    Route::post('get-all-emp-under-company-unit', 'UserApiController@get_all_emp_company_unit')->name('get-all-emp-role'); //

    Route::post('add-division', 'BranchController@add_division')->name('add-division');
    Route::post('add-company', 'ClientCompanyController@add_company')->name('add-company');
    Route::post('add-attendance', 'UserApiController@bulkAttendance')->name('add-attendance');
    Route::post('add-attendance-2', 'UserApiController@bulkAttendance_2')->name('add-attendance-2');
    Route::post('add-company-unit', 'ClientCompanyUnitController@add_company_unit')->name('add-company-unit');
    //transfer area rounder to another company unit
    Route::post('transfer-area-rounder/{id}', 'UserApiController@transfer_area_rounder')->name('transfer-area-rounder');
});
