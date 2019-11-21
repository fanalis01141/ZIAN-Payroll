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

use App\Deduction;
use App\Schedule;
use Carbon\Carbon;
use App\User;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

Route::get('/', function () {
    return view('welcome');
});


Route::POST('/setPosition', 'DepartmentController@setPosition')->name('setPosition');
Route::POST('/delPosition', 'DepartmentController@delPosition')->name('delPosition');
Route::POST('/editDeduction', 'DeductionController@editDeduction')->name('editDeduction');

Route::POST('/newHoliday', 'HomeController@newHoliday')->name('newHoliday');


Route::post('/employee/{id}/promote','PivotController@promote')->name('employee.promote');
Route::post('/employee/{id}/terminate','PivotController@terminate')->name('employee.terminate');
Route::post('/employee/{id}/edit-emp','PivotController@editEmp')->name('employee.editEmp');
Route::post('/employee/{id}/time','PivotController@time')->name('employee.time');
Route::post('/department/{department_name}/position','DepartmentController@newPosition')->name('department.position');
Route::post('/item/{itemid}/deduct', 'ItemController@deduct')->name('item.deduct');
Route::post('/item/{itemid}/add', 'ItemController@add')->name('item.add');
Route::post('/accept-leave', 'LeaveController@acceptleave')->name('leave.accept-leave');
Route::post('/depid', 'HomeController@fetchdepartment');
Route::post('/overtime/{id}','PivotController@fileOvertime')->name('employee.fileOvertime');

Auth::routes();

Route::group(['middleware' => ['auth' , 'admin']], function () {

    Route::resource('employee', 'PivotController');
    Route::resource('item', 'ItemController');
    Route::resource('leave', 'LeaveController');
    Route::resource('attendance', 'AttendanceController');
    Route::resource('department', 'DepartmentController');
    Route::resource('deduction', 'DeductionController');

    Route::get('/deductions', 'DeductionController@index')->name('deductions');
    Route::get('/attendance', 'AttendanceController@index')->name('attendance');
    Route::get('/settings', 'HomeController@settings')->name('settings');
    Route::get('/leave', 'LeaveController@index')->name('leave');
    Route::get('/employee/{id}/accountability', 'PivotController@accountability')->name('employee.accountability');
    Route::get('/cash-advance', 'DeductionController@showCA')->name('ded.showCA');
    Route::get('/cash-advance/{id}', 'DeductionController@storeCA')->name('ded.storeCA');
    Route::post('/cash-advance-edit/{id}', 'DeductionController@editCA')->name('ded.editCA');
    Route::post('/cash-advance-delete/{id}', 'DeductionController@deleteCA')->name('ded.delCA');


    Route::get('/homedashboard', 'HomeController@homedashboard')->name('homedashboard');

    Route::get('/employees', 'HomeController@dashboard')->name('dashboard');

    Route::get('/payroll', 'PayrollController@index')->name('payroll');


    Route::POST('/setPosition', 'DepartmentController@setPosition')->name('setPosition');
    Route::POST('/delPosition', 'DepartmentController@delPosition')->name('delPosition');
    Route::POST('/setHoliday', 'PivotController@setHoliday')->name('setHoliday');
    Route::POST('/delHoliday', 'PivotController@delHoliday')->name('delHoliday');

    Route::POST('/editDeduction', 'DeductionController@editDeduction')->name('editDeduction');
    Route::post('/employee/{id}/promote','PivotController@promote')->name('employee.promote');
    Route::post('/employee/{id}/terminate','PivotController@terminate')->name('employee.terminate');
    Route::post('/employee/{id}/edit-emp','PivotController@editEmp')->name('employee.editEmp');
    Route::post('/employee/{id}/time','PivotController@time')->name('employee.time');
    Route::post('/department/{department_name}/position','DepartmentController@newPosition')->name('department.position');
    Route::post('/item/{itemid}/deduct', 'ItemController@deduct')->name('item.deduct');
    Route::post('/item/{itemid}/add', 'ItemController@add')->name('item.add');
    Route::post('/accept-leave', 'LeaveController@acceptleave')->name('leave.accept-leave');
    Route::post('/depid', 'HomeController@fetchdepartment');
    Route::post('/OTstatus/{id}', 'PivotController@OTstatus')->name('OT.status');
    Route::post('/seekdate', 'AttendanceController@seekdate')->name('attendance.seekdate');



    Route::post('users/create-new', function (Request $request) {

    // return $request;
    $time_in_24_hour_format_timein  = date("H:i", strtotime($request->timein));
    $time_in_24_hour_format_timeout  = date("H:i", strtotime($request->timeout));

    request()->validate([
        'password' => 'required|min:3',
    ]);

    if($request->salary_type != 'FIXED'){

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

        Schedule::create([
            'emp_id' => $user->id,
            'dayoff' => $request->dayoff,
            'req_in' => $time_in_24_hour_format_timein,
            'req_out' => $time_in_24_hour_format_timeout
        ]); 

    }else{

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

        Schedule::create([
            'emp_id' => $user->id,
            'dayoff' => 'NA',
            'req_in' => 'NA',
            'req_out' =>'NA'
        ]); 
        
    }

    Deduction::create([
        'emp_id' => $user->id,
        'phic' => $request->phic == null ? $request->phic : '0',
        'sss' => $request->sss == null ? $request->sss : '0',
        'pagibig' => $request->pag_ibig  == null ? $request->pag_ibig : '0',
    ]);


    return redirect()->route('dashboard', $user->id)->with('success', 'SUCCESSFULLY ADDED NEW EMPLOYEE: '. $request->name);

    })->name('users.create');
});


Route::group(['middleware' => ['auth', 'user']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/overtime/{id}','PivotController@fileOvertime')->name('employee.fileOvertime'); //employee
});





