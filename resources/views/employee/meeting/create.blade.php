@extends('layouts.employee.app')

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
            <div class="card mt-5" id="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Book CR</h4>

                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('employee.meeting.store') }}" id="meeting_form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">

                                    <select name="cr_id" id="cr_id" class="custom-select">
                                        <option value="">Select CR</option>
                                        @foreach ($cr_rooms as $cr_room)
                                            <option value="{{ $cr_room->id }}">{{ $cr_room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="bmd-label-floating">Date</label>
                                    <input type="text" class="form-control" name="meeting_date" id="meeting_date"
                                        autocomplete="off" value="{{ old('meeting_date') }}" style="background: white">
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="from_time">From Time</label>
                                        <input type="text" name="from_time" id="from_time" class="form-control"
                                            autocomplete="off" value="{{ old('from_time') }}" style="background: white">
                                    </div>
                                    <div class="col">
                                        <label for="to_time">To Time</label>
                                        <input type="text" name="to_time" id="to_time" class="form-control"
                                            autocomplete="off" value="{{ old('to_time') }}" style="background: white">

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group text-center mt-5">
                            {{-- <button class="btn btn-primary  loading" style="display: none;" type="button">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="sr-only">Loading...</span>
                            </button> --}}

                            <button class="btn btn-primary loading" type="button" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Booking...
                            </button>
                            <button type="submit" class="btn btn-primary meeting_btn">Book Meeting</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')

    <script type="text/javascript">
        $("#meeting_date").flatpickr({
            disableMobile: true
        });

        $(document).ready(function() {

            $("#from_time").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "G:i K",
                minuteIncrement: 15,
                disableMobile: true,
                minTime: "8:30",

            });

            $("#to_time").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "G:i K",
                minuteIncrement: 15,
                disableMobile: true,
                minTime: "8:30",


            });

            //submitting meetings
            $('#meeting_form').submit(function(e) {
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

                $('.loading').show();
                $('.meeting_btn').hide();

                $.ajax({
                    type: "POST",
                    url: "{{ route('employee.meeting.store') }}",
                    data: data,

                    success: function(response) {
                        $('.loading').hide();
                        swal("Done", "Successfully Booked", "success");
                        $('#meeting_form').trigger('reset');
                        $('.meeting_btn').show();
                    },
                    error: function(response) {
                        $('.loading').hide();
                        let validation_errors = response.responseJSON.errors;

                        let errors = '';
                        for (const key in validation_errors) {
                            errors += validation_errors[key];
                            errors += '\n';
                        }
                        swal("Cancelled", errors, 'error');
                        $('.meeting_btn').show();

                    }
                });

            });
        });

    </script>
@endpush
