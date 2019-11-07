@extends('layouts.app')

@section('content-dashboard')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow">
                <h4 class="card-header text-light bg-secondary">
                    <div class="row">
                        <div class="col-lg-10"> <i class="fas fa-cog mr-1"></i> Departments</div>
                        <div class="col-lg-2 text-right"><button class="btn btn-primary shadow" data-target="#new-department-modal" data-toggle="modal">  <i class="fa fa-plus"></i></button></div>
                    </div>


                </h4>
                <div class="card-body">
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                                @endif

                            @foreach ($department as $row)
                                <div class="card">
                                    <div class="card-header text-light bg-info">
                                        <div class="row">
                                        <div class="col-9"><h4>{{$dept = $row->department_name}}</h4></div>
                                            <div class="col-3 text-right"><button class="btn btn-primary btn-sm btn-new-position" id=""><i class="fas fa-plus"></i> Add New Position</button></div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                    <h5 class=" text-secondary">Positions</h5>
                                       <table class="table table-hover">
                                        <tbody>

                                            @foreach ($position as $item)
                                                @if($item->department_name == $dept)
                                                    <tr class="trposition">
                                                    <td>
                                                        <input type="hidden" name="posid" class="position-id" value="{{$item->id}}">
                                                        <p class="position-name">{{$item->position}}</p>
                                                    </td>
                                                    <td class="text-right">
                                                        <button class="btn btn-outline-primary btn-sm btn-edit-position" id="btn-edit-position" data-target="#edit-position-modal" data-toggle="modal"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-outline-danger btn-sm btn-delete-position" data-target="#delete-position-modal" data-toggle="modal"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                          </table>
                                        <form action="{{route('department.position', $row->department_name)}}" method="POST">
                                            @csrf
                                            <div class="new-position-input" style="display:none">
                                                <div class="input-group">
                                                <input type="hidden" name="department_name" value="{{$row->department_name}}">
                                                <input type="text" class="form-control new-pos-text" name="new_position" placeholder="Enter New Position" aria-label="Enter New Position" aria-describedby="button-addon4">
                                                <div class="input-group-append" id="button-addon4">
                                                    <button class="btn btn-success px-5" type="submit">Save</button>
                                                    <button class="btn btn-secondary btn-cancel" type="button">Cancel</button>
                                                </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br>
                                @endforeach
                            </div>
                        </div>
                        <br>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow">
                    <h5 class="card-header bg-secondary text-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h4><i class="fas fa-cog mr-1"></i>  Holidays </h4>
                            </div>
                            <div class="col-md-2 text-right">
                                <button class="btn btn-sm btn-primary shadow" data-target="#new-holiday" data-toggle="modal"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </h5>
                    <div class="card-body">
                        @if (session('success-holiday'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success-holiday') }}
                        </div>
                        @endif

                        <table class="table table-hover">
                        <thead>
                            <tr class="text-secondary">
                            <th scope="col">Holiday Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Day</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holidays as $item)
                                <tr>
                                    <td class="holiday-name">{{$item->holiday_name}}</td>
                                <input type="hidden" name="" class="holiday-id" value="{{$item->id}}">
                                <td>{{date("M. d, Y", strtotime($item->holiday_date))}} <input type="hidden" class="holiday-date" name="" value="{{$item->holiday_date}}"></td>
                                    <td>{{$item->holiday_day}}</td>
                                    <td class="">
                                        <button class="btn btn-outline-primary btn-sm btn-edit-holiday" id="btn-edit-holiday" data-target="#edit-holiday-modal" data-toggle="modal"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-outline-danger btn-sm btn-delete-position" data-target="#delete-holiday-modal" data-toggle="modal"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>


{{-- New Department Mondal --}}
<div class="modal fade" id="new-department-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{route('department.store')}}" method="POST">
        <div class="modal-dialog" role="document">
          <div class="modal-content modal-lg">
            <div class="modal-header text-light bg-primary">
              <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-building mr-1"></i> New Department  </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @csrf

                <p class="mb-0">Department Name:</p>
                <input type="text" class="form-control" name="department_name" id="department_name" placeholder="department" required>
                <br>
                <p class="mb-0">Position under this department:</p>
                <input type="text" class="form-control" name="position" id="position" placeholder="position" required>

            </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- end of new department modal --}}



{{-- edit modal --}}
<div class="modal fade" id="edit-position-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form action="{{route('setPosition')}}" method="POST">
        @csrf
        <div class="modal-dialog" role="document">
          <div class="modal-content modal-lg">
            <div class="modal-header bg-primary">
              <h5 class="modal-title text-light " id="exampleModalLabel">Edit Position</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <br>
                <input type="hidden" id="modal-position-id-del" name="id">
                <p class="mb-0">Position:</p>
                <input type="text" class="form-control" name="new_position" id="edit-position" placeholder="position" required>

            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">SAVE</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- end edit modal  --}}


{{-- delete modal --}}
<div class="modal fade" id="delete-position-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{route('delPosition')}}" method="POST">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-light " id="exampleModalLabel">Delete Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <br>
                    <input type="hidden" id="delete-id" name="id" value="">
                    <p>Are you sure you want to delete position:</p>
                    <p class="text-primary" id="delete-position"></p>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- end delete modal  --}}

    {{-- New holiday modal --}}
<div class="modal fade" id="new-holiday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{route('newHoliday')}}" method="POST">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-lg">
                    <div class="modal-header text-light bg-primary">
                        <h4> <i class="far fa-calendar-plus"></i> Add Holiday</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <br>
                        <p class="mb-0">Holiday Name:</p>
                        <input type="text" class="form-control" name="holiday_name" id="edit-position" placeholder="holiday name" required>
                        <br>
                        <p class="mb-0">Date:</p>
                        <input type="date" name="holiday_date" id="hired" class="form-control new-employee-input mb-3" required value="{{old('hired')}}">
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">SAVE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- New holiday modal  --}}


        {{-- edit holiday modal --}}
<div class="modal fade" id="edit-holiday-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{route('setHoliday')}}" method="POST">
                @csrf
                <div class="modal-dialog" role="document">
                  <div class="modal-content modal-lg">
                    <div class="modal-header bg-primary">
                      <h5 class="modal-title text-light " id="exampleModalLabel"><i class="fas fa-edit"></i> Edit Holiday</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                            <input type="hidden" id="modal-holiday-id" name="id">
                            <p class="mb-0">Holiday Name:</p>
                            <input type="text" class="form-control" name="holiday_name" id="name-holiday" placeholder="holiday name" required>
                            <br>
                            <p class="mb-0">Date:</p>
                            <input type="date" name="holiday_date" id="hired" class="form-control new-employee-input mb-3 date-holiday" required value="{{old('hired')}}">
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">SAVE</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- end edit holiday modal  --}}

        {{-- delete modal --}}
    <div class="modal fade" id="delete-holiday-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{route('delHoliday')}}" method="POST">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-light " id="exampleModalLabel">Delete Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <br>
                    <input type="hidden" id="delete-holiday" name="id" value="">
                    <p>Are you sure you want to delete this selected Holiday?</p>
                    <small class="text-secondary"><p>Make sure that this is legit</p></small>
                    <p class="text-primary" id="delete-position"></p>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
        {{-- end delete modal  --}}



@endsection
