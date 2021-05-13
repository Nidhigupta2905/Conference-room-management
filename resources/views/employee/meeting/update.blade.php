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
            <div class="card mt-5">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Book CR</h4>

                </div>
                <div class="card-body">

                    <div id="loader"></div>
                    <form method="POST" action="{{ route('employee.meeting.update', ['meeting' => $meeting->id]) }}"
                        id="update_meeting_form">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">

                                    <select name="cr_id" id="cr_id" class="custom-select">
                                        <option value="{{ $meeting->conferenceRoom->id }}">
                                            {{ $meeting->conferenceRoom->name }}</option>
                                        @foreach ($cr_rooms as $cr_room)
                                            <option value="{{ $cr_room->id }}">{{ $cr_room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="bmd-label-floating">Date</label>
                                    <input type="text" class="form-control" name="meeting_date" id="meeting_date"
                                        autocomplete="off" value="{{ date('Y-m-d', strtotime($meeting->meeting_date)) }}">
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="from_time">From Time</label>
                                        <input type="text" name="from_time" id="from_time" class="form-control"
                                            autocomplete="off" value="{{ $meeting->from_time }}">
                                    </div>
                                    <div class="col">
                                        <label for="to_time">To Time</label>
                                        <input type="text" name="to_time" id="to_time" class="form-control"
                                            autocomplete="off" value="{{ $meeting->to_time }}">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Book</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <script type="text/javascript">
        $(function() {
            $("#meeting_date").datepicker({
                dateFormat: 'yy-mm-dd',
                // minDate: 0,
                // maxDate: 0
            });
        });

        $(document).ready(function() {

            // $.ajaxSetup({
            //     headers: {
            //         'X - CSRF - TOKEN': $('meta[name = "csrf-token"]').attr('content')
            //     }
            // });
            $('#from_time').timepicker({
                timeFormat: 'H:i',
                step: 15,
                disableTimeRanges: [

                ]
            });

            $('#to_time').timepicker({
                timeFormat: 'H:i',
                step: 15,
                disableTimeRanges: [

                ]
            });

            //submitting meetings
            $('#update_meeting_form').submit(function(e) {
                e.preventDefault();

                var _token = $('input[name=_token]').val();
                var cr_id = $('#cr_id').val();
                var meeting_date = $('#meeting_date').val();
                var from_time = $('#from_time').val();
                var to_time = $('#to_time').val();

                const data = {
                    _token: _token,
                    cr_id: cr_id,
                    meeting_date: meeting_date,
                    from_time: from_time,
                    to_time: to_time
                }

                $.ajax({
                    type: "PUT",
                    url: $('#update_meeting_form').attr('action'),
                    data: data,

                    success: function(response) {
                        console.log(response);
                        swal("Done", "Successfully Booked", "success");
                        $('#update_meeting_form').trigger('reset');
                    },
                    error: function(response) {
                        let validation_errors = response.responseJSON.errors;

                        if ("errors" in validation_errors) {
                            let error = '';
                            for (const key in validation_errors) {
                                error += validation_errors["errors"].join('\n');
                                error += '\n';
                            }
                            swal("Cancelled", error, 'error');
                        } else {
                            let errors = '';
                            for (const key in validation_errors) {
                                errors += validation_errors[key];
                                errors += '\n';
                            }

                            swal("Cancelled", errors, 'error');
                        }
                    }


                });

            });

        });

    </script>
@endpush
