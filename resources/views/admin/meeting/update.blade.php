@extends('layouts.admin.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-8 offset-2">

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

                    <form method="POST" action="{{ route('admin.meetings.update', ['meeting' => $meeting->id]) }}"
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
                                        autocomplete="off" value="{{ date('Y-m-d', strtotime($meeting->meeting_date)) }}"
                                        style="background: white">
                                </div>

                                <div class="row">
                                    <div class="col bootstrap-timepicker">
                                        <label for="from_time">From Time</label>
                                        <input type="text" name="from_time" id="from_time" class="form-control"
                                            autocomplete="off"
                                            value="{{ Carbon\Carbon::parse($meeting->from_time)->format('H:i') }}">
                                    </div>
                                    <div class="col">
                                        <label for="to_time">To Time</label>
                                        <input type="text" name="to_time" id="to_time" class="form-control"
                                            autocomplete="off"
                                            value="{{ Carbon\Carbon::parse($meeting->to_time)->format('H:i') }}">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-2 loading" style="display: none;" type="button">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="sr-only">Loading...</span>
                        </button>
                        <button type="submit" class="btn btn-primary mt-2 meeting_btn">Book</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <script src="{{ asset('admin/dist/js/flatpickr.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js">

    </script>

    <script type="text/javascript">
        $(function() {
            $("#meeting_date").flatpickr({

            });
        });

        $(document).ready(function() {

            //Timepicker

            //timepicker
            $("#from_time").timepicker({
                timeFormat: 'H:mm',
                interval: 15,

            });


            $('#to_time').timepicker({
                timeFormat: 'H:mm',
                interval: 15,
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

                $('.loading').show();
                $('.meeting_btn').hide();

                $.ajax({
                    type: "PUT",
                    url: $('#update_meeting_form').attr('action'),
                    data: data,

                    success: function(response) {
                        $('.loading').hide();
                        console.log(response);
                        swal("Done", "Successfully Booked", "success");
                        window.location.href = "{{ route('admin.meetings.index') }}"
                        $('.meeting_btn').show();
                    },
                    error: function(response) {

                        $('.loading').hide();
                        var errors = response.responseJSON.errors;

                        var error = '';
                        for (const key in errors) {
                            error += errors[key].join('\n');
                            error += '\n';
                        }
                        swal("Cancelled", error, 'error');
                        $('.meeting_btn').show();

                    }
                });

            });

        });

    </script>
@endpush
