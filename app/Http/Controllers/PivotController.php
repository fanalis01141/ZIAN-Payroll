<?php

namespace App\Http\Controllers;

use App\Deduction;
use App\holiday;
use App\Item;
use App\User;
use App\Leave;
use App\Department;
use App\Overtime;
use App\Schedule;
use DateTime;
use Illuminate\Http\Request;
use OverflowException;

class PivotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $date1 = "";
        $date2 = "";
        $day = "";
        $sched = Schedule::where('emp_id', $id)->first();

        if($sched->req_in == 'NA'){
            $in = 'Not applicable.';
            $out = 'Not applicable.';
            $day = 'Not applicable';
        }else{
            $date1 = new DateTime($sched->req_in);
            $date2 = new DateTime($sched->req_out);
            $in = $date1->format('h:i a') ;
            $out = $date2->format('h:i a') ;
        }


        if($sched->dayoff == 'SUN'){
            $day = 'Sunday';
        }elseif($sched->dayoff == 'MON'){
            $day = 'Monday';
        }elseif($sched->dayoff == 'TUE'){
            $day = 'Tuesday';
        }elseif($sched->dayoff == 'WED'){
            $day = 'Wednesday';
        }elseif($sched->dayoff == 'THU'){
            $day = 'Thursday';
        }elseif($sched->dayoff == 'FRI'){
            $day = 'Friday';
        }elseif($sched->dayoff == 'SAT'){
            $day = 'Saturday';
        }

        $user = User::findOrFail($id);
        $showDep = Department::distinct()->get('department_name');
        $showPos = Department::all();
        $deductions = Deduction::where('emp_id', $id)->first();
        $sched = Schedule::where('emp_id', $id)->first();
        return view('admin.employee', compact('user','sched','in','out','day','deductions','showDep','showPos','sched'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        return $request;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd ($request);
        User::where('id', $id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'rate' => $request->rate,
            'salary_type' => $request->new_salary_type,
            'department' => $request->department,
            'position' => $request->position,
            'weeks_of_training' => $request->weeks_of_training,
        ]);
        
        $off = "";
        if($request->new_salary_type == 'FIXED'){
            $off = 'SUN';
        }else{
            $off = $request->new_dayoff;
        }
        Schedule::where('emp_id', $id)->update([
                
            'dayoff' => $off,
            'req_in' => $request->new_timein == null ? 'NA' : $request->new_timein,
            'req_out' => $request->new_timeout == null ? 'NA' : $request->new_timeout
        ]);

        Deduction::where('emp_id', $id)->update([
            'phic' => $request->phic,
            'sss' => $request->sss,
            'pagibig' => $request->pagibig
        ]);

        return redirect()->back()->with('success', 'Edited details of ' . $request->name);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //edit holiday
    public function setHoliday(Request $request){
        $id = $request->id;
        $newName = $request->holiday_name;
        $newDate = $request->holiday_date;
        holiday::where('id',$id)->update(['holiday_name' => $newName, 'holiday_date' => $newDate]);
        return back()->with('success-holiday', 'Holiday Successfully Updated');
    }

    public function delHoliday(Request $request){
        $id = $request->id;
        holiday::where('id',$id)->delete();
        return back()->with('success-holiday', 'Holiday Successfully Deleted');
    }




    public function promote($id, Request $request){
        // return $request;
        $user = User::findOrFail($id);

        if($user->rate > $request->new_rate){
            return back()->withErrors('Please enter a higher rate for promotion');
        }


        $promotion = '';
        if($user->emp_status == 'TRAINEE'){
            $promotion = 'PROBATIONARY';
        }else{
            $promotion = 'REGULAR';
        }
        User::where('id', $user->id)->update(['emp_status' => $promotion,
            'weeks_of_training' => $request->new_training,
            'rate' => $request->new_rate
        ]);
        return redirect()->back()->with('success', 'Successfully promoted ' . $user->name . ' to : ' .$promotion);
    }

    public function terminate($id){
        $user = User::findOrFail($id);
        User::where('id',$id)->update([
            'active' => '0'
            ]);
        return redirect()->route('dashboard')->with('success','YOU HAVE TERMINATED ' . $user->name);
    }

    public function accountability($id){
        $data = array();
        $data['user'] = User::findOrFail($id);
        $data['items'] = Item::where('emp_id', $id)->where('quantity','!=','0')->get();
        // return $data['items'];
        return view ('admin.accountability', compact('data'));
    }

    public function editEmp($id, Request $request){
        return request()->all();
    }

    public function fileOvertime(Request $request, $id)
    {
        $user = Overtime::where(['emp_id'=> $id,
                        'date' => $request->date])->first();
        if($user != null || $user != ""){
            return redirect()->route('home')->withErrors('Overtime request existing for date: ' . date("F jS, Y", strtotime($request->date)));
        }else{
            Overtime::create([
                'emp_id' => $id,
                'reason' => $request->reason,
                'date' => $request->date,
                'minutes' => $request->minutes,
                'status' => 'PENDING'
            ]);
            return redirect()->route('home')->with('success', 'Overtime requested for date: ' . date("F jS, Y", strtotime($request->date)));
        }
    }

    public function OTstatus(Request $request, $id){
        $user = User::findOrFail($id);

        Overtime::where('emp_id', $id)->update([
            'status' => strtoupper($request->status)
        ]);

        return redirect()->route('homedashboard')->with('success', 'YOU ' . strtoupper($request->status) . ' REQUESTED OVERTIME OF '  . $user->name);
    }

}
