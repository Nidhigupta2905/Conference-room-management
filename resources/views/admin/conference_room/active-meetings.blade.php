@extends('layouts.admin.app')

@push('css')

@endpush
@section('content')

    <div class="card mt-5" id="card">

        

        <div class="card-body">
            <h1 class="text-danger">{{ $cr_room->name }}</h1>

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
                            </tr>
                        @endforeach
                    </tbody>

                </table>
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
