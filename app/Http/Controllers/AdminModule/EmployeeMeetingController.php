<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\employee\UpdateFormRequest;
use App\Mail\MeetingBookingMail;
use App\Models\ConferenceRoom;
use App\Models\Meeting;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Spatie\GoogleCalendar\Event;

class EmployeeMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::now()->startOfDay();

        $meetings = Meeting::where('meeting_date', $today)
            ->orderBy('meeting_date', 'ASC')
            ->withTrashed('user', 'conferenceRoom')
            ->get();

        return view('admin.meeting.index')->with([
            'meetings' => $meetings,
            'page' => 'meeting-history',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
        return view('admin.meeting.update')->with([
            'meeting' => $meeting,
            'cr_rooms' => $crs,
            'page' => 'meeting',
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, $id)
    {

        $meeting = Meeting::find($id);

        $meeting->update($request->getUpdateData());

        $cr = $meeting->conferenceRoom()->first();

        $employee = $meeting->user()->first();

        //mail

        $meeting_start_time = Carbon::parse($request->from_time, 'Asia/Kolkata')->format("h:i A");
        $meeting_end_time = Carbon::parse($request->to_time, 'Asia/Kolkata')->format("h:i A");

        $meetingDetails = [
            'header' => "CR Management System",
            'title' => Auth::user()->name . ' rescheduled a meeting for ' . $employee->name . ' in ' . $cr->name . " CR",
            'body' => 'Timings: ' . $meeting_start_time . ' to ' . $meeting_end_time . ' on ' . $request->meeting_date,
            'footer' => 'If you have any concerns with this rescheduling, please talk to Admin. Thank you.',
        ];

        // \Mail::to($employee->email)->send(new MeetingBookingMail($meetingDetails));

        //google calendar events
        $event = new Event();

        $meetingStartTime = Carbon::parse($request->from_time, 'Asia/Kolkata');
        $meetingEndTime = Carbon::parse($request->to_time, 'Asia/Kolkata');

        $event = Event::find($meeting->event_id);
        $event->delete();

        $events = Event::create([
            'name' => Auth::user()->name . ' rescheduled a meeting for ' . $employee->name . ' in ' . $cr->name . " CR",
            'startDateTime' => $meetingStartTime,
            'endDateTime' => $meetingEndTime,
        ]);

        $meeting->event_id = $events->id;
        $meeting->save();

        return Response::json(array(
            'success' => true,
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $meeting = Meeting::find($id);

        $cr = $meeting->conferenceRoom()->first();

        $employee = $meeting->user()->first();

        $event = Event::find($meeting->event_id);

        $event->delete();
        $meeting->delete();

        //mail

        $meeting_start_time = Carbon::parse($meeting->from_time, 'Asia/Kolkata')->format("h:i A");
        $meeting_end_time = Carbon::parse($meeting->to_time, 'Asia/Kolkata')->format("h:i A");

        $meetingDetails = [
            'header' => "CR Management System",
            'title' => Auth::user()->name . ' cancelled your meeting in ' . $cr->name . " CR",
            'body' => 'For the time: ' . $meeting_start_time . ' to ' . $meeting_end_time . ' on ' . $meeting->meeting_date,
            'footer' => 'If you have any concerns with this cancellation, please talk to Admin. Thank you.',
        ];

        // \Mail::to($employee->email)->send(new MeetingBookingMail($meetingDetails));

        return Response::json(array(
            'success' => true,
            'message' => "deleted",
            "data" => $id,
        ), 200);

    }

    //employee meeting history
    public function meetingHistory(Request $request)
    {
        //auto delete meetings for previous 2 days
        $delete_meetings = Meeting::where('meeting_date', '<', Carbon::now()->subDays(2))->get();
        foreach ($delete_meetings as $delete_meeting) {
            $delete_meeting->delete();
        }

        $meetings = Meeting::withTrashed(['user', 'conferenceRoom'])
            ->orderBy('meeting_date', 'DESC')
            ->get();

        return view('admin.meeting.meeting-history')->with([
            'page' => 'meetingHistory',
            'meetings' => $meetings,
        ]);
    }

}
