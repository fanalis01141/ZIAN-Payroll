@extends('layouts.app')

@section('content-dashboard')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if ($errors->any())
                <p class="badge badge-danger"><h3>Error in adding new employee:</h3></p>
                @foreach ($errors->all() as $error)
                    <p style="color:red">{{$error}}</p>
                @endforeach
            @endif

            <div class="card shadow">
                <h4 class="card-header text-light bg-secondary">
                    <div class="row">
                    <div class="col-lg-8">
                        EMPLOYEES
                    </div>
                    <div class="col-lg-4 text-right">
                        <button class="btn btn-primary btn-sm shadow" data-toggle="modal" data-target="#addnew"><i class="fa fa-plus"></i> New Employee</button>
                    </div>
                    </div>
                </h4>
                <div class="card-body">

                    {{-- Success message --}}
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Employee table --}}

                    <table class="table table-hover table-striped table-bordered text-center">
                        <thead class="text-secondary">
                            <tr>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Position</th>
                                <th scope="col">Rate / Day</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td scope="col">{{$user->name}}</td>
                                <td scope="col">{{$user->department}}</td>
                                <td scope="col">{{$user->position}}</td>
                                <td scope="col">{{$user->rate}}</td>
                                <td class="">

                                    <div class="text-center">
                                        <a href="{{route('employee.show', $user->id)}}" class="btn btn-success btn-sm">
                                                <i class="far fa-eye"></i>&nbsp;View Details</a>
                                        <a href="{{route('employee.accountability', $user->id)}}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-archive"></i>&nbsp;Accountability</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            {{$users->links()}}
        </div>
    </div>

</div>

<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header  text-light bg-primary">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add New Employee Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('users.create')}}" method="POST">
                @csrf
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Employee Details</a>
                        </li>
                        <li class="nav-item ">
                          <a class="nav-link disabled" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Deductions</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                             {{-- modalbody --}}
                <div class="modal-body">
                    <div class="alert alert-warning font-weight-bold" id="error-empty" role="alert" style="display:none;">
                        Please fill out all the fields.
                      </div>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="name">Employee Name</label>
                                <input type="text" name="name" class="form-control new-employee-input" required value="{{old('name')}}">
                            </div>

                            <div class="col-md-6">
                                <label for="hired">Date Hired</label>
                                <input type="date" name="hired" id="hired" class="form-control new-employee-input mb-3" required value="{{date('Y-m-d')}}">
                            </div>
                        </div>

                        <div class="demo"></div>

                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label for="email">Username</label>
                                <input type="text" name="username" class="form-control new-employee-input" required value="{{old('username')}}">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control new-employee-input" required value="{{old('password')}}">
                            </div>
                            <div class="col-md-4 mt-2" id="colll">
                                <label for="password">Confirm Password</label>
                                    <a href="#" data-tooltip="Password not match" class="tt">
                                        <i id="exclam" class="fas fa-exclamation ml-1 fa-2x hider" style="color:red"></i>
                                    </a>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control new-employee-input" required value="{{old('password')}}">
                            </div>
                        </div>
                        <hr class="col-md-5">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="rate"><strong>Enter DAILY RATE:</strong></label>
                                <input type="number" name="rate" class="form-control new-employee-input" required value="{{old('rate')}}" min="1" max="10000">
                            </div>
                            <div class="col-md-4">
                                <label for="inlineRadio1">Enter WEEKS of training:</label>
                                <input type="number" name="weeks_of_training" class="form-control new-employee-input" required value="{{old('rate')}}" min="1" max="10000">
                            </div>
                            <div class="col-md-4">
                                <label for="salary_type">Salary Type:</label>
                                <select class="form-control" name="salary_type" id="salary_type">
                                    <option disabled selected value="">--Choose Salary Type--</option>
                                    <option value="FIXED">Fixed</option>
                                    <option value="HOURLY">Hourly</option>
                                </select>
                            </div>
                        </div>
                        <hr class="mt-3">



                        <div class="row">
                            <div class="col-md-6">
                                <label for="select1">Department</label>
                                <select name="department" id="department" class="form-control new-employee-input" required>
                                    <option disabled selected>--Select Department--</option>
                                    @foreach ($showDep as $rowDep)
                                    <option value="{{$selectedDep=$rowDep->department_name}}">{{$rowDep->department_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="select2">Position</label>
                                <select name="position" id="position" class="form-control new-employee-input" required>
                                    <option disabled selected value="">--Select Position--</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-warning text-center font-weight-bold" style="display:none">
                            <i class="fas fa-exclamation-triangle mr-3"></i>Please double check the required time-in and required time-out of the Employee.
                        </div>
                        <div class="row mt-3 row-timein" style="display:none" id="div_salary">
                            <div class="col-md-4">
                                <label for="dayoff">ENTER DAY OFF:</label>
                                <select name="dayoff" id="dayoff" class="form-control" required>
                                    <option disabled selected value="">--Select Dayoff--</option>
                                    <option value="SUN">Sunday</option>
                                    <option value="MON">Monday</option>
                                    <option value="TUE">Tuesday</option>
                                    <option value="WED">Wednesday</option>
                                    <option value="THU">Thursday</option>
                                    <option value="FRI">Friday</option>
                                    <option value="SAT">Saturday</option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="timein">TIME IN:</label>
                                <input type="text" class="timepicker form-control" id="timein" name="timein" required>
                            </div>

                            <div class="col-md-4">
                                <label for="timein">TIME OUT:</label>
                                <input type="text" class="timepicker form-control" id="timeout" name="timeout" required>
                            </div>
                        </div>

                    </div>

                    {{-- endmodalbody --}}
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                            <div class="form-row">
                                                <div class="col-3 text-right">
                                                    <label for="inputPhic">PHIC</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" name="phic" value="0" id="inputPhic" placeholder="amount" required>
                                                </div>
                                            </div><br>
                                            <div class="form-row">
                                                <div class="col-3 text-right">
                                                    <label for="inputSSS">SSS</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" value="0"  name="sss" id="inputSSS" placeholder="amount" required>
                                                </div>
                                            </div><br>
                                            <div class="form-row">
                                                <div class="col-3 text-right">
                                                    <label for="inputPagIbig">PAG-IBIG</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" value="0"  name="pag_ibig" id="inputPagIbig" placeholder="amount" required>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                      </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="button" id="btnNext">NEXT</button>
                    <button type="submit" class="btn btn-success" id="btnSave" style="display:none;">SAVE</button>
                </div>
            </form>
            </div>
        </div>
    </div>

@endsection
