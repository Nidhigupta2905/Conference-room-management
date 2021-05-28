@extends('layouts.admin.app')
@push('css')
    
@endpush
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
            <div class="card mt-5" id="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Add Employee</h4>

                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.employee.store') }}">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Employee Name</label>
                                    <input type="text" class="form-control" name="employee_name" id="employee_name">
                                </div>

                                <div class="form-group">
                                    <label class="bmd-label-floating">Email address</label>
                                    <input type="email" class="form-control" name="employee_email" id="employee_email">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary pull-right">Add Employee</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
