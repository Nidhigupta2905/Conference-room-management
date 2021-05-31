@extends('layouts.admin.app')

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
                    <div class="card mt-5" id="card">

                        <div class="card-header card-header-primary">

                            <a class="btn btn-info float-right" href="{{ route('admin.employee.meeting-history') }}">See
                                all
                                Meetings</a>
                            <h4 class="card-title ">Today's Meeting List</h4>

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
                                            From Time
                                        </th>
                                        <th>To Time</th>
                                        <th>Actions</th>
                                    </thead>

                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($meetings as $meeting)

                                            <tr id="meeting_data_{{ $meeting->id }}">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $meeting->user->name }}</td>

                                                <td>{{ $meeting->conferenceRoom->name }}</td>
                                                <td class="start_date">
                                                    {{ date('d-m-y', strtotime($meeting->meeting_date)) }}</td>
                                                <td class="start_time">
                                                    {{ Carbon\Carbon::parse($meeting->from_time)->format('h:i a') }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($meeting->to_time)->format('h:i a') }}
                                                </td>

                                                @if ($meeting->deleted_at == null)
                                                    <td>
                                                        @php
                                                            $now = Carbon\Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                                                        @endphp
                                                        @if ($now->lt(Carbon\Carbon::parse($meeting->from_time, 'Asia/Kolkata')))

                                                            <button class="btn btn-danger loading_{{ $meeting->id }}"
                                                                type="button" id="loading" style="display: none;">
                                                                <span class="spinner-border spinner-border-sm" role="status"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Loading...</span>
                                                            </button>

                                                            <button
                                                                class="btn btn-danger delete_button_{{ $meeting->id }}"
                                                                id="delete_button" data-id="{{ $meeting->id }}"
                                                                data-token="{{ csrf_token() }}"><i
                                                                    class="far fa-window-close"></i></button>

                                                            <a href="{{ route('admin.meetings.edit', $meeting->id) }}"
                                                                type="submit" class="btn btn-info edit_button_{{$meeting->id}}" id="edit_button"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endif
                                                    </td>
                                                @else
                                                    <td>
                                                        @php
                                                            $now = Carbon\Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                                                        @endphp
                                                        @if ($now->lt(Carbon\Carbon::parse($meeting->from_time, 'Asia/Kolkata')))

                                                            <button class="btn btn-danger loading" type="button"
                                                                id="loading" style="display: none;">
                                                                <span class="spinner-border spinner-border-sm" role="status"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Loading...</span>
                                                            </button>

                                                            <button class="btn btn-danger delete_button_{{$meeting->id}}" id="delete_button"
                                                                data-id="{{ $meeting->id }}"
                                                                data-token="{{ csrf_token() }}" disabled><i
                                                                    class="far fa-window-close"></i></button>
                                                        @endif
                                                    </td>

                                                @endif
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

    <script>
        $(document).ready(function() {
            $('body').on('click', '#delete_button', function(e) {
                e.preventDefault();
                console.log("clicked");
                var id = $(this).data("id");
                var token = $(this).data("token");

                const payLoad = {
                    'id': id,
                    '_method': 'DELETE',
                    '_token': token
                }

                if (confirm("Are you sure you want to delete!")) {
                    $('.loading_' + id).show();
                    $('.delete_button_' + id).hide();
                    $.ajax({
                        type: "DELETE",
                        url: "meetings/" + id,
                        data: payLoad,

                        success: function(response) {
                            console.log(response);
                            $('#meeting_data_' + id).hide();
                            setInterval(() => {
                                 $('.loading_' + id).hide();
                                $('.edit_button_'+id).hide();

                                $('.delete_button_'+id).show();
                                $('.delete_button_'+id).prop('disabled', true);

                                $('#meeting_data_' + id).show();

                            }, 2000);
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });

            $('#meeting_list_table').DataTable({
                "bInfo": false
            });
        });

    </script>

    {{-- <script src="{{ asset('js/employee/meeting.js') }}"></script> --}}

@endpush
