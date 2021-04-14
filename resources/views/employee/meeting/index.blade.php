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
                    <div class="card">

                        <div class="card-header card-header-primary">

                            <a class="btn btn-info pull-right" href="{{ route('employee.meeting.create') }}"><i
                                    class="material-icons">
                                    add_circle_outline</i>Add</a>
                            <h4 class="card-title ">Meeting List</h4>
                            <p class="card-category"> Here is a subtitle for this table</p>
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
                                        <td>CR Name</td>

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

                                                    {{-- <form
                                                        action="{{ route('employee.meeting.destroy', ['meeting' => $user_meeting->id]) }}"
                                                        method="post" class="d-inline" id="delete_meeting_form">
                                                        @method('DELETE')
                                                        @csrf --}}
                                                    <a href="{{ route('employee.meeting.destroy', ['meeting' => $user_meeting->id]) }}"
                                                        type="submit" class="btn btn-danger" id="delete_button"
                                                        data-id="{{ $user_meeting->id }}"><i class="material-icons">
                                                            delete
                                                        </i></a>
                                                    {{-- </form> --}}
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
    <script src="{{ asset('js/employee/meeting.js') }}"></script>

    {{-- <script>
        $(document).ready(function () {
            $('#meeting_list_table').DataTable();
        });
    </script> --}}
@endpush
