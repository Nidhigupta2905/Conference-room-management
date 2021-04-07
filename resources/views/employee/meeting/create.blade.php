@extends('layouts.employee.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">

            @if (session('success'))
                <div class="alert alert-success ">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger ">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('error') }}</strong>
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
                    <h4 class="card-title">Book CR</h4>

                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('employee.meeting.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    {{-- <label class="bmd-label-floating">CR Name</label>
                                    <input type="text" class="form-control" name="employee_name" id="employee_name"> --}}

                                    <select name="cr_name" id="cr_name" class="custom-select">
                                        <option value="">Select CR</option>
                                        @foreach ($cr_rooms as $cr_room)
                                            <option value="{{ $cr_room->id }}">{{ $cr_room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="bmd-label-floating">Date</label>
                                    <input type="text" class="form-control" name="meeting_date" id="meeting_date"
                                        autocomplete="off" value="{{ old('meeting_date') }}">
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="from_time">From Time</label>
                                        <input type="text" name="from_time" id="from_time" class="form-control"
                                            autocomplete="off" value="{{ old('meeting_date') }}">
                                    </div>
                                    <div class="col">
                                        <label for="to_time">To Time</label>
                                        <input type="text" name="to_time" id="to_time" class="form-control"
                                            autocomplete="off" value="{{ old('meeting_date') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary pull-right">Book</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')

    <script type="text/javascript">
        $(function() {
            $("#meeting_date").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0,
                maxDate: 0
            });
        });

        $(document).ready(function() {
            $('#from_time').timepicker({
                timeFormat: 'HH:mm',
                interval: 15
            });
        });

        $(document).ready(function() {
            $('#to_time').timepicker({
                timeFormat: 'HH:mm',
                interval: 15
            });
        });

    </script>
@endsection
