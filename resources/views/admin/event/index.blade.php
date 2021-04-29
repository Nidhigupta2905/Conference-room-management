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
                                            Event Name
                                        </th>

                                        <th>
                                            Start Time
                                        </th>
                                        <th>
                                            End Name
                                        </th>
                                    </thead>

                                    <tbody class="font-weight-bold">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($events as $google_events)

                                            <tr id="meeting_data_{{ $google_events->id }}">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $google_events->summary }}</td>

                                                <td> {{ Carbon\Carbon::parse($google_events->start->dateTime, 'Asia/Kolkata')->format('h:i a') }}</td>

                                                <td> {{ Carbon\Carbon::parse($google_events->end->dateTime, 'Asia/Kolkata')->format('h:i a') }}</td>

                                                <td>

                                                    {{-- <form
                                                        action="{{ route('employee.meeting.destroy', ['meeting' => $user_meeting->id]) }}"
                                                        method="post" class="d-inline" id="delete_meeting_form">
                                                        @method('DELETE')
                                                        @csrf --}}
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
