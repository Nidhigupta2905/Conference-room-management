<?php

namespace App\Http\Controllers\EmployeeModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\employee\StoreFormRequest;
use App\Http\Requests\employee\UpdateFormRequest;
use App\Mail\MeetingBookingMail;
use App\Models\ConferenceRoom;
use App\Models\Employee;
use App\Models\Meeting;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        $meeting = $user->meetings()->withTrashed([
            'conferenceRoom', 'user',
        ])->orderBy('from_time', 'ASC')->where('meeting_date', $today)->get();
        return view('employee.meeting.index')->with([
            'page' => 'meeting-history',
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
    public function store(StoreFormRequest $request)
    {
        $meeting = Meeting::create($request->getData());

        $cr = $meeting->conferenceRoom()->first();

        //google calendar events
        $meetingStartTime = Carbon::parse($request->from_time, 'Asia/Kolkata');
        $meetingEndTime = Carbon::parse($request->to_time, 'Asia/Kolkata');

        $event = Event::create([
            'name' => Auth::user()->name . ' booked a meeting in ' . $cr->name . " CR",
            'startDateTime' => $meetingStartTime,
            'endDateTime' => $meetingEndTime,
        ]);

        $meeting->event_id = $event->id;
        $meeting->save();

        //mail details
        $startTime = Carbon::parse($request->from_time, 'Asia/Kolkata')->format('h:i A');
        $endTime = Carbon::parse($request->to_time, 'Asia/Kolkata')->format('h:i A');

        $meetingDetails = [
            'header' => "CR Management System",
            'title' => Auth::user()->name . ' booked a meeting in ' . $cr->name . " CR",
            'body' => 'Timings: ' . $startTime . ' to ' . $endTime . ' on ' . $request->meeting_date,
            'footer' => 'If you have any concerns with this meeting, please talk to the Admin. Thank you.',
        ];

        // \Mail::to(Auth::user()->email)->send(new MeetingBookingMail($meetingDetails));

        return Response::json(array(
            'success' => true,
        ), 200);

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
    public function update(UpdateFormRequest $request, $id)
    {

        $meeting = Meeting::find($id);

        $meeting->update($request->getUpdateData());

        $cr = $meeting->conferenceRoom()->first();

        //mail details

        $meeting_start_time = Carbon::parse($request->from_time, 'Asia/Kolkata')->format("h:i A");
        $meeting_end_time = Carbon::parse($request->to_time, 'Asia/Kolkata')->format("h:i A");

        $meetingDetails = [
            'header' => "CR Management System",
            'title' => Auth::user()->name . ' rescheduled a meeting in ' . $cr->name . " CR",
            'body' => 'Timings: ' . $meeting_start_time . ' to ' . $meeting_end_time . ' on ' . $request->meeting_date ,
            'footer' => 'If you have any concerns with this leave, please talk to Admin. Thank you.',
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

        return Response::json([
            'success' => true,
            'message' => 'Meeting booking successfull',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $meeting = Meeting::find($id);

        $event = Event::find($meeting->event_id);

        $event->delete();
        $meeting->delete();

        return Response::json(array(
            'success' => true,
            'message' => "deleted",
            "data" => $id,
        ), 200);
    }

    //user's meeting history
    public function meetingHistory(Request $request)
    {

        //auto delete meetings for previous 2 days
        $delete_meetings = Meeting::where('meeting_date', '<', Carbon::now()->subDays(2))->get();
        foreach ($delete_meetings as $delete_meeting) {
            $delete_meeting->delete();
        }

        $user = Auth::user();
        $meeting = $user->meetings()->withTrashed([
            'conferenceRoom', 'user',
        ])->orderBy('meeting_date', 'DESC')->get();

        return view('employee.meeting.meeting-history')->with([
            'page' => 'meeting-history',
            'meeting' => $meeting,
        ]);
    }

}
