@extends('layouts.admin.app')

@push('css')

@endpush
@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 mx-auto">

                    <div class="card mt-5" id="card">

                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Cancelled Meeting List</h4>
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
                                    </thead>

                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($cancelled_meetings as $cancelled_meeting)

                                            <tr id="meeting_data_{{ $cancelled_meeting->id }}">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $cancelled_meeting->user->name }}</td>
                                                <td>{{ $cancelled_meeting->conferenceRoom->name }}</td>
                                                <td class="start_date">
                                                    {{ date('d-m-y', strtotime($cancelled_meeting->meeting_date)) }}</td>
                                                <td class="start_time">
                                                    {{ Carbon\Carbon::parse($cancelled_meeting->from_time)->format('h:i a') }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($cancelled_meeting->to_time)->format('h:i a') }}
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
    <script>
        $(document).ready(function() {
            $('#meeting_list_table').DataTable({
                "bInfo": false
            });
        });

    </script>
@endpush
