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
use Spatie\GoogleCalendar\Event;

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

            $cr = $meeting->conferenceRoom()->first();

            //mail
            $meetingDetails = [
                'title' => Auth::user()->name . ' booked a meeting in ' . $cr->name . " CR",
                'body' => 'Testing Mail',
            ];

            // \Mail::to(Auth::user()->email)->send(new MeetingBookingMail($meetingDetails));

            //google calendar events
            $event = new Event();

            $meetingStartTime = Carbon::parse($request->from_time, 'Asia/Kolkata');
            $meetingEndTime = Carbon::parse($request->to_time, 'Asia/Kolkata');

            $events = Event::create([
                'name' => Auth::user()->name . ' booked a meeting in ' . $cr->name . " CR",
                'startDateTime' => $meetingStartTime,
                'endDateTime' => $meetingEndTime,
            ]);

            $meeting->event_id = $events->id;
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
    public function edit($id)
    {

        $user = Auth::user();
        $cr_meeting = $user->meetings()->with([
            'conferenceRoom',
        ])->get();

        $meeting = Meeting::find($id);
        $crs = ConferenceRoom::all();
        return view('employee.meeting.update')->with([
            'meeting' => $meeting,
            'cr_rooms' => $crs,
            'page' => 'meeting',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

        $meeting = Meeting::find($id);

        $check_meeting_start_time = Meeting::where('from_time', $request->from_time)
            ->whereDate('meeting_date', $request->meeting_date)
            ->where('conference_room_id', $request->cr_id)
            ->first(); // TODO: fix

        //check today's date
        $today = Carbon::now()->startOfDay();

        $input_date = Carbon::parse($request->meeting_date)->startOfDay();

        $meeting_id = $meeting->id;
        $from_time = $request->from_time;
        $to_time = $request->to_time;

        $check_start_time_conflict = Meeting::whereDate('meeting_date', $request->meeting_date)
            ->where('conference_room_id', $request->cr_id)
            ->where(function ($query) use ($from_time, $to_time, $meeting_id) {
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
            })
            ->where(function ($query) use ($meeting_id) {
                $query->where('id', '!=', $meeting_id);
            })
            ->exists();

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

            $cr = $meeting->conferenceRoom()->first();

            //mail
            $meetingDetails = [
                'title' => Auth::user()->name . ' rescheduled a meeting in ' . $cr->name . " CR",
                'body' => 'Testing Mail',
            ];

            // \Mail::to(Auth::user()->email)->send(new MeetingBookingMail($meetingDetails));

            //google calendar events
            $event = new Event();

            $meetingStartTime = Carbon::parse($request->from_time, 'Asia/Kolkata');
            $meetingEndTime = Carbon::parse($request->to_time, 'Asia/Kolkata');

            $event = Event::find($meeting->event_id);
            $event->delete();

            $events = Event::create([
                'name' => Auth::user()->name . ' rescheduled a meeting in ' . $cr->name . " CR",
                'startDateTime' => $meetingStartTime,
                'endDateTime' => $meetingEndTime,
            ]);

            $meeting->event_id = $events->id;
            $meeting->save();

            return Response::json(array(
                'success' => true,
            ), 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Request $request, $id, $event_id)
    // {
    //     Meeting::where('id', $id)->delete();

    //     // Meeting::destroy($id);
    //     $event = Event::find($event_id);
    //     $event->delete();

    //     return Response::json(array(
    //         'success' => true,
    //         'message' => "deleted",
    //         "data" => $id,
    //     ), 200);
    // }

    public function delete(Request $request, $id, $event_id)
    {
        Meeting::where('id', $id)->delete();

        // Meeting::destroy($id);
        $event = Event::find($event_id);
        $event->delete();

        return Response::json(array(
            'success' => true,
            'message' => "deleted",
            "data" => $id,
            "event_id" => $event_id,
        ), 200);
    }
    //user's meeting history
    public function meetingHistory()
    {
        $user = Auth::user();
        $meeting = $user->meetings()->with([
            'conferenceRoom',
        ])->orderBy('meeting_date', 'DESC')->get();

        return view('employee.meeting.meeting-history')->with([
            'page' => 'meeting-history',
            'meeting' => $meeting,
        ]);
    }
}
