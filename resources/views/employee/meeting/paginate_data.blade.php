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
                    <td>{{ $i + ($meeting->currentPage() - 1) * $meeting->perPage() }}</td>
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

    {{ $meeting->links() }}
</div>
