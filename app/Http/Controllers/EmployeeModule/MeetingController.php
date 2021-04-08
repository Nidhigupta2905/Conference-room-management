<?php

namespace App\Http\Controllers\EmployeeModule;

use App\Http\Controllers\Controller;
use App\Models\ConferenceRoom;
use App\Models\Employee;
use App\Models\Meeting;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meeting = Meeting::all();
        return view('employee.meeting.index')->with([
            'meetings' => $meeting,
            'page' => 'meeting',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cr_rooms = ConferenceRoom::all();
        return view('employee.meeting.create')->with([
            'cr_rooms' => $cr_rooms,
            'page' => 'meeting',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // TODO: validation
        $meeting = new Meeting();

        // $meeting_data = Meeting::all();

        $check_meeting_start_time = Meeting::where('from_time', $request->from_time)
            ->whereDate('meeting_date', $request->meeting_date)
            ->where('conference_room_id', $request->cr_id)
            ->first(); // TODO: fix

        // $check_end_time_conflict = Meeting::where('to_date', '<', $request->to_date)->first();

        //check today's date
        $today = Carbon::now()->startOfDay();

        $input_date = Carbon::parse($request->meeting_date)->startOfDay();

        $from_time = $request->from_time;
        $to_time = $request->to_time;

        // DB::enableQueryLog();

        $check_start_time_conflict = Meeting::whereDate('meeting_date', $request->meeting_date)
            ->where('conference_room_id', $request->cr_id)
            ->where(function ($query) use ($from_time, $to_time) {
                $query->orWhere('from_time', $from_time)
                    ->orWhere(function ($query) use ($from_time, $to_time) {
                        $query->where('from_time', '<', $from_time)
                            ->where('to_time', '>', $from_time);
                    })
                    ->orWhere('to_time', $to_time)
                    ->orWhere(function ($query) use ($from_time, $to_time) {
                        $query->where('from_time', '<', $to_time)
                            ->where('to_time', '>', $to_time);
                    })
                    ->orWhere(function ($query) use ($from_time, $to_time) {
                        $query->where('from_time', '>', $from_time)
                            ->where('to_time', '<', $to_time);
                    });
            })->exists();

// dd(DB::getQueryLog($check_start_time_conflict));

        if ($check_meeting_start_time) {
            $request->session()->flash('error', 'Booked Already for the time. Choose another CR');
            return back()->withInput();
        }

        // checking time conflicts
        else if ($check_start_time_conflict) {
            $request->session()->flash('error', 'Choose a different meeting start time');
            return redirect()->back()->withInput();
        } else if ($input_date != $today) {
            $request->session()->flash('error', 'Cannot Book for the next day');
            return redirect()->back()->withInput();
        } else {
            $meeting->conference_room_id = $request->cr_id;
            $meeting->meeting_date = $request->meeting_date;
            $meeting->from_time = $request->from_time;
            $meeting->to_time = $request->to_time;
            $meeting->user_id = Auth::user()->id;
            $meeting->save();
            $request->session()->flash('success', 'Meeting Booked Successfully');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
