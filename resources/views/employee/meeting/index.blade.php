@extends('layouts.employee.app')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 mx-auto">

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

                            <a class="btn btn-info float-right" href="{{ route('employee.meeting-history') }}">View All
                                Meetings</a>
                            <h4 class="card-title ">Meeting List</h4>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table" id="meeting_list_table">
                                    <thead class=" text-primary">
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            User Name
                                        </th>
                                        <th>CR Name</th>

                                        <th>Meeting Date</th>

                                        <th>
                                            Start Time
                                        </th>
                                        <th>End Time</th>

                                        <th>
                                            Actions
                                        </th>
                                    </thead>

                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($meeting as $user_meeting)

                                            <tr id="meeting_data_{{ $user_meeting->id }}">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $user_meeting->user->name }}</td>
                                                <td>{{ $user_meeting->conferenceRoom->name }}</td>
                                                <td class="start_date">
                                                    {{ date('d-m-y', strtotime($user_meeting->meeting_date)) }}</td>
                                                <td class="start_time">
                                                    {{ Carbon\Carbon::parse($user_meeting->from_time)->format('h:i a') }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($user_meeting->to_time)->format('h:i a') }}
                                                </td>
                                                <td>
                                                    @php
                                                        $now = Carbon\Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                                                    @endphp

                                                    @if ($now->lt(Carbon\Carbon::parse($user_meeting->from_time, 'Asia/Kolkata')))
                                                        <button class="btn btn-danger loading" type="button" id="loading"
                                                            style="display: none;">
                                                            <span class="spinner-border spinner-border-sm" role="status"
                                                                aria-hidden="true"></span>
                                                            <span class="sr-only">Loading...</span>
                                                        </button>

                                                        {{-- <a href="{{ route('employee.meeting.destroy', ['meeting' => $user_meeting->id]) }}"
                                                            type="submit" class="btn btn-danger delete_button"
                                                            id="delete_button" data-id="{{ $user_meeting->id }}"
                                                            ><i
                                                                class="far fa-trash-alt"></i></a> --}}

                                                        <button class="btn btn-danger "
                                                        id="delete_button"
                                                            data-id="{{ $user_meeting->id }}"
                                                            data-token="{{ csrf_token() }}"><i
                                                                class="far fa-trash-alt"></i></button>

                                                        <a href="{{ route('employee.meeting.edit', $user_meeting->id) }}"
                                                            type="submit" class="btn btn-info" id="edit_button"><i
                                                                class="fas fa-edit"></i></a>

                                                    @endif

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
        </div>
    </div>
@endsection

@push('js')

    {{-- <script src="{{ asset('js/employee/meeting.js') }}"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            $('#delete_button').click(function (e) { 
                e.preventDefault();
                console.log("clicked");
                var id = $(this).data("id");
                var token = $(this).data("token");

                const payLoad = {
                    'id': id,
                    '_method': 'DELETE',
                    '_token': token
                }

                $('#loading').show();
                confirm("Are you sure you wnat to delete!")
                $('.delete_button').hide();

                $.ajax({
                    type: "DELETE",
                    url: "meeting/"+id,
                    data: payLoad,
                   
                    success: function (response) {
                        console.log(response);
                        $('#meeting_data_'+id).hide();
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            });

            $('#meeting_list_table').DataTable();
        });

    </script>

@endpush
