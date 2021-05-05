@extends('layouts.employee.app')

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

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

                            <a class="btn btn-info pull-right" href="{{ route('employee.meeting.index') }}">See Today's Meetings</a>
                            <h4 class="card-title ">Meeting List</h4>
                            <p class="card-category"> Here is a subtitle for this table</p>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table" id="meeting_list_table">
                                    <thead class="text-primary">
                                        <th>
                                            S.No
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
                                    </thead>

                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($meeting as $user_meeting)

                                            <tr class="highlight_tr">
                                                <td>{{ ($i + ($meeting->currentPage() - 1) * $meeting->perPage()) }}</td>
                                                <td>{{ $user_meeting->user->name }}</td>
                                                <td>{{ $user_meeting->conferenceRoom->name }}</td>
                                                <td class="start_date">
                                                    {{ date('d-m-y', strtotime($user_meeting->meeting_date)) }}</td>
                                                <td class="start_time">
                                                    {{ Carbon\Carbon::parse($user_meeting->from_time)->format('h:i a') }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($user_meeting->to_time)->format('h:i a') }}
                                                </td>

                                            </tr>
                                            @php
                                                $i++
                                            @endphp
                                        @endforeach
                                    </tbody>

                                </table>

                                {{ $meeting->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
