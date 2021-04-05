@extends('layouts.admin.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">

            @if (session('success'))
                <div class="alert alert-success ">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
            @endif
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Edit Employee</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.employee.update', $employee->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Employee Name</label>
                                    <input type="text" class="form-control" name="employee_name" id="employee_name"
                                        value="{{ $employee->name }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="bmd-label-floating">Employee Name</label>
                                    <input type="text" class="form-control" name="employee_email" id="employee_email"
                                        value="{{ $employee->email }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary pull-right">Update Name</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
