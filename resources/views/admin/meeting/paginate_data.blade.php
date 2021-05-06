<form action="{{route('admin.meetings.search')}}" method="get">
    <input type="text" name="search" id="search" class="form-control" placeholder="Search" style="width: 300px;"
        name="search" id="search">
    <button class="btn btn-success">Search</button>
</form>

<div class="table-responsive">
    <table class="table" id="meeting_list_table">
        <thead class=" text-primary">
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
            @foreach ($meetings as $user_meeting)

                <tr class="highlight_tr">
                    <td>{{ $i + ($meetings->currentPage() - 1) * $meetings->perPage() }}</td>
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
                    $i++;
                @endphp
            @endforeach
        </tbody>

    </table>
    {{ $meetings->links() }}
</div>
