<?php

namespace App\Http\Controllers\EmployeeModule;

use App\Http\Controllers\Controller;
use App\Models\ConferenceRoom;
use App\Models\Employee;
use App\Models\Meeting;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $today = Carbon::now()->startOfDay();

        $meeting = $user->meetings()->with([
            'conferenceRoom',
        ])->orderBy('from_time', 'ASC')->where('meeting_date', $today)->get();
        return view('employee.meeting.index')->with([
            'page' => 'meeting',
            'meeting' => $meeting,
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

        $validator = Validator::make($request->all(), [
            'cr_id' => 'required',
            'meeting_date' => 'required|date_format:Y-m-d',
            'from_time' => 'required|date_format:H:i',
            'to_time' => 'required|date_format:H:i|after:from_time',
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->errors()->all(),
            ), 422);
        }
        $meeting = new Meeting();

        $check_meeting_start_time = Meeting::where('from_time', $request->from_time)
            ->whereDate('meeting_date', $request->meeting_date)
            ->where('conference_room_id', $request->cr_id)
            ->first(); // TODO: fix
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
            return Response::json(array(
                'success' => false,
                'errors' => ["Booked Already for the time. Choose another CR"],
            ), 422);
        }

        // checking time conflicts
        else if ($check_start_time_conflict) {
            return Response::json(array(
                'success' => false,
                'errors' => ["Choose a different meeting start time"],
            ), 422);
        } else if ($input_date != $today) {
            return Response::json(array(
                'success' => false,
                'errors' => ["Cannot Book for the next day"],
            ), 422);
        } else {
            $meeting->conference_room_id = $request->cr_id;
            $meeting->meeting_date = $request->meeting_date;
            $meeting->from_time = $request->from_time;
            $meeting->to_time = $request->to_time;
            $meeting->user_id = Auth::user()->id;
            $meeting->save();
            return Response::json(array(
                'success' => true,
            ), 200);
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
    public function destroy(Request $request, $id)
    {
        Meeting::where('id', $id)->delete();
        $request->session()->flash('success', 'Meeting Deleted Successfully');
        return redirect()->back();
    }

    public function meetingHistory()
    {
        $user = Auth::user();
        $meeting = $user->meetings()->with([
            'conferenceRoom',
        ])->orderBy('from_time', 'ASC')->get();

        return view('employee.meeting.meeting-history')->with([
            'page' => 'meeting-history',
            'meeting' => $meeting,
        ]);
    }
}
