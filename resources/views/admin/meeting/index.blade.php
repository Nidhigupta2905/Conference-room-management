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
                    <div class="card">

                        <div class="card-header card-header-primary">

                            <a class="btn btn-info pull-right" href="{{ route('admin.employee.meeting-history') }}">See
                                all
                                Meetings</a>
                            <h4 class="card-title ">Today's Meeting List</h4>
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
                                        <th>CR Name</th>

                                        <th>Meeting Date</th>

                                        <th>
                                            From Time
                                        </th>
                                        <th>To Time</th>
                                        <th>Actions</th>
                                    </thead>

                                    <tbody class="font-weight-bold">
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

                                                <td>

                                                    {{-- <form
                                                        action="{{ route('admin.events.destroy', ['event' => $google_events->id]) }}"
                                                        method="post" class="d-inline" id="delete_event_form">
                                                        @method('DELETE')
                                                        @csrf --}}

                                                    <a href="{{ route('admin.meeting.delete', ['id' => $meeting->id, 'event_id' => $meeting->event_id]) }}"
                                                        type="submit" class="btn btn-danger" id="delete_button"
                                                        data-id="{{ $meeting->id }}"><i class="material-icons">
                                                            delete
                                                        </i></a>

                                                    <a href="{{ route('admin.meetings.edit', $meeting->id) }}"
                                                        type="submit" class="btn btn-info" id="edit_button"><i
                                                            class="material-icons">
                                                            edit
                                                        </i></a>
                                                    {{-- <a href="{{ route('employee.meeting.destroy', ['meeting' => $user_meeting->id]) }}"
                                                        type="submit" class="btn btn-danger" id="delete_button"
                                                        data-id="{{ $user_meeting->id }}"><i class="material-icons">
                                                            delete
                                                        </i></a> --}}
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

@endpush
