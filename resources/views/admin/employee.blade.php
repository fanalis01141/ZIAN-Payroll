@extends('layouts.app')

@section('content-dashboard')

    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <i class="far fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $err)
                    <li>{{$err}}</li>
                @endforeach
            </div>
        @endif


        <div class="row" id="detailsss">

            <div class="col-lg-9">
                <div class="card shadow">
                    @csrf
                    <h4 class="card-header text-light bg-dark">
                        <a class="btn btn-light mr-2" href="{{route('dashboard')}}"><i class="fas fa-arrow-left"></i> Back</a> EMPLOYEE DETAILS
                    </h4>
                    <div class="card-body">
                            <div class="jumbotron py-1 jumbotron-fluid">
                                <div class="container">
                                    <div class="text-right">
                                        <button id="editemp" href="#" class=" btn btn-outline-primary mt-3">Edit<i class="fas fa-pencil-alt ml-3"></i></button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <h1 class="display-5">{{strtoupper($user->name)}}</h1>
                                            <h5 class=" mt-4">
                                                Department: {{strtoupper($user->department)}} | 
                                                Position: {{($user->position)}}
                                            </h5>
                                            <h5 class="">Daily Rate: {{$user->rate}}</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-secondary">Employee's Username</small>
                                            <p class="lead">{{$user->username}}</p>
                                            <small class="text-secondary">Employment Status</small>
                                            <p class="lead">{{$user->emp_status}}</p>
                                            <small class="text-secondary">Salary Type</small>
                                            <p class="lead">{{$user->salary_type}}</p>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-secondary">Employee's time-in</small>
                                            <p class="lead">
                                            
                                                {{$in}}
                                            </p>
                                            <small class="text-secondary">Employee's time-out</small>
                                            <p class="lead">{{$out}}</p>
                                            <small class="text-secondary">Employee's day-off</small>
                                            <p class="lead">{{$day}}</p>
                                            
                                        </div>
                                    </div>
                                    <hr>
                                    
                                    
                                </div>
                                <div class="container text-center">
                                    <h3>Deductions:</h3>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <h3 class="text-secondary">PAG-IBIG:</h3>
                                            <h4>{{$deductions->pagibig}}</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="text-secondary">PHIC:</h3>
                                            <h4>{{$deductions->phic}}</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="text-secondary">SSS:</h3>
                                            <h4>{{$deductions->sss}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <div class="text-center py-3" id="divsave" style="display:none;">
                            <div class="row">
                                <div class="col-md-10 text-left">

                                    <h1 class="mb-3 ml-5">Edit Details for {{$user->name}}</h1>
                                </div>
                                <div class="col-md-2">

                                    <button id="close_edit" class="btn btn-outline-danger">Close
                                        <i class="fa fa-times-circle float-right ml-3 mt-1" aria-hidden="true" style="color:red"></i>
                                    </button>
                                </div>
                            </div>
                            
                        <hr>

                        <form action="{{route('employee.update', $user->id)}}" method="post">
                            @csrf
                            @method('patch')
                            <h3></h3>

                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                                <p class="font-weight-bold">Please double check details before saving!</p>
                            </div>
                            <div class="row">
                                

                                <div class="col-md-3">
                                    <h3>
                                        <i class="fa fa-user" aria-hidden="true" style="color:blue"></i> Details:
                                    </h3>
                                    <hr>
                                    <div class="text-center">
                                        <div class="">
                                            <label for="name">Employee Name</label>
                                            <input type="text" name="name" class="form-control" required value="{{$user->name}}" required>
                                        </div>
                                        <div class="c">
                                            <label for="username">Username</label>
                                            <input type="text"  id="username" name="username" class="form-control" required value="{{$user->username}}" required>
                                        </div>

                                        <div class="">
                                            <label for="rate">Daily Rate:</label>
                                            <input type="number"  id="rate" name="rate" class="form-control" required value="{{$user->rate}}" min="1" max="10000" required>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                        <h3>
                                            <i class="fa fa-building" aria-hidden="true" style="color:darkorange"></i> Other details:
                                        </h3>
                                        <hr>
                                    <div class="">
                                        <label for="name">Employee's Salary Type:</label>
                                        <select class="form-control" name="new_salary_type" id="new_salary_type" required>
                                            <option disabled selected>--Choose Salary Type--</option>
                                            <option value="FIXED" {{ $user->salary_type=="FIXED"?'selected':""}}>FIXED</option> 
                                            <option value="HOURLY" {{ $user->salary_type=="HOURLY"?'selected':""}}>HOURLY</option>                                            
                                        </select>
                                    </div>
                                    <div class="">
                                        <label for="select1">Department</label>
                                        <select name="department" id="department" class="form-control new-employee-input" required>
                                            <option value="">--Select Department--</option>
                                            @foreach ($showDep as $rowDep)
                                            <option value="{{$selectedDep=$rowDep->department_name}}">{{$rowDep->department_name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="">
                                        <label for="select2">Position</label>
                                        <select name="position" id="position" class="form-control new-employee-input" required>
                                            <option value="">--Select Position--</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label for="inlineRadio1">Weeks Of Training:</label>
                                        <input type="number"  id="weeks_of_training" name="weeks_of_training"  class="form-control" required value="{{$user->weeks_of_training}}" min="1" max="10000" required>
                                    </div>
                                </div>

                                <div class="col-md-3" style="display:none" id="schedule">
                                        <h3>
                                            <i class="fa fa-clock" aria-hidden="true" style="color:mediumorchid"></i> Schedule:
                                        </h3>
                                        <hr>
                                    <div class="">
                                        <label for="inlineRadio1">Required Dayoff:</label>

                                        <select name="new_dayoff" id="new_dayoff" class="form-control" required>
                                                <option disabled selected value="">--Select Dayoff--</option>
                                                <option value="SUN" {{ $sched->dayoff=="SUN"?'selected':""}}>Sunday</option>
                                                <option value="MON" {{ $sched->dayoff=="MON"?'selected':""}}>Monday</option>
                                                <option value="TUE" {{ $sched->dayoff=="TUE"?'selected':""}}>Tuesday</option>
                                                <option value="WED" {{ $sched->dayoff=="WED"?'selected':""}}>Wednesday</option>
                                                <option value="THU" {{ $sched->dayoff=="THU"?'selected':""}}>Thursday</option>
                                                <option value="FRI" {{ $sched->dayoff=="FRI"?'selected':""}}>Friday</option>
                                                <option value="SAT" {{ $sched->dayoff=="SAT"?'selected':""}}>Saturday</option>
                                            </select>
                                    </div>
                                    <div class="">
                                        <label for="name">Required Time-in</label>
                                        <input type="text" class="timepicker form-control" id="new_timein" name="new_timein" required>
                                    </div>
                                    <div class="">
                                        <label for="name">Required Time-out</label>
                                        <input type="text" class="timepicker form-control" id="new_timeout" name="new_timeout" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                        <h3>
                                            <i class="fa fa-minus-circle" aria-hidden="true" style="color:crimson"></i> Deductions:
                                        </h3>
                                        <hr class="">
                                    <div class="row">
                                        <div class="">
                                            <label for="PHIC">PHIC:</label>
                                            <input type="number" class="form-control ml-2" name="phic" value="{{$deductions->phic}}" id="inputPhic" placeholder="PHIC amount" required>
                                        </div>
                                        <div class="">
                                            <label for="SSS">SSS:</label>
                                            <input type="number" class="form-control ml-2" name="sss" value="{{$deductions->sss}}" id="inputPhic" placeholder="PHIC amount" required>
                                        </div><div class="">
                                            <label for="PAG-IBIG">PAG-IBIG</label>
                                            <input type="number" class="form-control ml-2" name="pagibig" value="{{$deductions->pagibig}}" id="inputPhic" placeholder="PHIC amount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" mt-3">

                                <button class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Changes</a>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow">
                    <h4 class="card-header bg-secondary text-light">Actions</h4>
                    <div class="card-body">
                            @if ($user->emp_status != 'REGULAR')
                                    <button class="btn btn-success btn-lg btn-block"
                                    data-myid="{{$user->id}}" data-myname="{{$user->name}}" data-mystatus="{{$user->emp_status}}"
                                    data-toggle="modal" data-target="#promote" >Promote</button>
                                @endif
                            <small id="emailHelp" class="form-text text-muted">This will promote the chosen employee.</small>
                            <br>
                            <button class="btn btn-outline-danger btn-lg btn-block"
                                data-myid="{{$user->id}}" data-myname="{{$user->name}}"
                                data-target="#terminate" data-toggle="modal">Terminate</button>
                            <small id="emailHelp" class="form-text text-muted">This will remove the user from the payroll system and biometrics.</small>

                    </div>
                </div>
            </div>
        </div>


    </div>








    {{-- <form action="{{route('attendance.store',$user->id)}}" method="post">
    <div class="card">
            @csrf
            <div class="card-body">
                <input type="text" name="emp_id" id="emp_id" value="{{$user->id}}">
                <button type="submit">submit</button>
            </div>
        </div>
    </form> --}}


    <div class="modal fade" id="promote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{route('employee.promote',$user->id)}}" method="POST">
        <div class="modal-dialog" role="document">
          <div class="modal-content modal-lg">
            <div class="modal-header text-light bg-success">
              <h5 class="modal-title" id="exampleModalLabel">PROMOTION</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body text-center">
                @csrf
                {{-- @method('PATCH') --}}
                <h3>
                    <div class="alert alert-success">
                        <i class="fas fa-user-check fa-1x"></i>
                        <p class="ml-3">Are you sure you want to promote  </p>
                            <strong><label id="myname" class="ml-3"></label></strong>
                    </div>
                    <p class="ml-3">Employee will be promoted to:  </p>
                    <strong>
                        <h3>
                        <label id="mystatus" class="ml-3 badge badge-success" ></label>
                        </h3>
                    </strong>
                </h3>
                <input type="text" name="myid" id="myid" hidden>
                <a href="" class="badge badge-light" name="myname" id="myname"></a>
                <div class="row">

                    <div class="col-md-6">
                        <label for="new_rate">Enter New Rate / Day:</label>
                        <input type="number" name="new_rate" min="1" max="999999" class="form-control" required value="{{old('new_rate')}}">
                    </div>
                    <div class="col-md-6">
                        @if ($user->emp_status == 'TRAINEE')
                            <label for="new_rate">Enter Weeks as Probationary:</label>
                            <input type="number" name="new_training" min="1" max="999999" class="form-control" required value="{{old('new_training')}}">
                        @endif
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Continue</button>
                </div>
            </div>
        </div>
        </form>
    </div>

    <div class="modal fade" id="terminate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="{{route('employee.terminate',$user->id)}}" method="POST">
            <div class="modal-dialog" role="document">
              <div class="modal-content modal-lg">
                <div class="modal-header text-light bg-danger">
                  <h5 class="modal-title" id="exampleModalLabel">TERMINATE</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body text-center">
                    @csrf
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <h3>
                            <p class="ml-3">Are you sure you want to TERMINATE:  </p>
                                <strong><label id="mynameterminate" class="text-center"></label></strong>
                                <br>
                            </h3>
                        </div>
                        <p class="font-weight-bold">This cannot be undone!
                            </p>
                    <input type="text" name="myidterminate" id="myid" hidden>
                    <a href="" class="badge badge-light" name="myname" id="myname"></a>
                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-danger">Continue</button>
                    </div>

                </div>
            </div>
        </form>
    </div>



@endsection
