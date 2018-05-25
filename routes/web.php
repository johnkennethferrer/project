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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/monitor', 'LogsController@attendance_monitor')->name('monitor');


Route::resource('companies', 'CompaniesController');
Route::resource('logs', 'LogsController');
Route::resource('employees', 'EmployeesController');
Route::resource('roles', 'RolesController');

//employees
Route::post('/import_parse', 'EmployeesController@parseImport')->name('import_parse');
Route::post('/import_process', 'EmployeesController@processImport')->name('import_process');
Route::post('/import_csv', 'EmployeesController@importCsv')->name('import_csv');
Route::post('/upload_image', 'EmployeesController@uploadImage')->name('upload_image');

//roles
Route::get('/user_roles', 'RolesController@userRoles')->name('user_roles');
Route::post('/add_role_user', 'RolesController@addRoleUser')->name('add_role_user');




