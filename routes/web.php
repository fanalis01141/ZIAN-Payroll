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
use Carbon\Carbon;
use App\User;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Hash;




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('employee', 'PivotController');
Route::resource('item', 'ItemController');
Route::resource('leave', 'LeaveController');
Route::resource('attendance', 'AttendanceController');
Route::resource('deduction', 'DeductionController');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/homedashboard', 'HomeController@homedashboard')->name('homedashboard');

Route::get('/employees', 'HomeController@dashboard')->name('dashboard');
Route::get('/employees/{id}/deductions', 'HomeController@deductions')->name('deduction');




Route::post('/employee/{id}/promote','PivotController@promote')->name('employee.promote');
Route::post('/employee/{id}/terminate','PivotController@terminate')->name('employee.terminate');
Route::post('/employee/{id}/edit-emp','PivotController@editEmp')->name('employee.editEmp');
Route::post('/employee/{id}/time','PivotController@time')->name('employee.time');


Route::get('/employee/{id}/accountability', 'PivotController@accountability')->name('employee.accountability');
Route::post('/item/{itemid}/deduct', 'ItemController@deduct')->name('item.deduct');
Route::post('/item/{itemid}/add', 'ItemController@add')->name('item.add');
Route::post('/accept-leave/{id}', 'LeaveController@acceptleave')->name('leave.accept-leave');
Route::get('/cash-advance', 'DeductionController@showCA')->name('ded.showCA');
Route::get('/cash-advance/{id}', 'DeductionController@storeCA')->name('ded.storeCA');




Route::post('users/create-new', function (Request $request) {
    request()->validate([
        'username' => 'unique:users',
        'password' => 'required|min:3',
    ]);

    $user = User::create([
        'name' => $request->name,
        'date_hired' => $request->hired,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'weeks_of_training' => $request->weeks_of_training,
        'emp_status' => 'TRAINEE',
        'department' => $request->department,
        'rate' => $request->rate,
        'salary_type' => $request->salary_type,
        'position' => $request->position,
        'priority' => 'LO',
        'active' => '1',
        ]);

    return redirect()->route('deduction.show', $user->id)->with('success', 'SUCCESSFULLY ADDED NEW EMPLOYEE: '. $request->name);


})->name('users.create');
