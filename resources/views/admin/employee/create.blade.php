@extends('layouts.admin.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Edit Profile</h4>

                </div>
                <div class="card-body">
                    <form>
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Employee Name</label>
                                    <input type="text" class="form-control">
                                </div>


                                <div class="form-group">
                                    <label class="bmd-label-floating">Email address</label>
                                    <input type="email" class="form-control">
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
