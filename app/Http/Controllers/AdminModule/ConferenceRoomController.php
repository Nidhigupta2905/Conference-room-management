<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\conferenceRoom\StoreFormRequest;
use App\Models\ConferenceRoom;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ConferenceRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cr_rooms = new ConferenceRoom();
        $crs = ConferenceRoom::all();
        return view('admin.conference_room.index')->with([
            'cr_rooms' => $crs,
            'page' => 'cr_room',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.conference_room.create')->with([
            'page' => 'cr_room',
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

        $conference_room = ConferenceRoom::create($request->getData());
        return response()->json([
            'success' => true,
            'message' => 'CR Name uploaded successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meetings = Meeting::where('conference_room_id', $id)
            ->orderBy('meeting_date', 'ASC')
            ->withTrashed('user', 'conferenceRoom')
            ->get();

        $cr_room = ConferenceRoom::find($id);
        return view('admin.conference_room.show')->with([
            'cr_room' => $cr_room,
            'meetings' => $meetings,
            'page' => 'cr_room',
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
        $cr_room = ConferenceRoom::find($id);
        return view('admin.conference_room.update')->with([
            'cr_room' => $cr_room,
            'page' => 'cr_room',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'conference_room_name' => 'required|regex:/^[a-zA-z]/u|max:15,min:3|unique:conference_rooms,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $cr_room = ConferenceRoom::find($id);
        $cr_room->name = $request->conference_room_name;
        $cr_room->save();

        return response()->json([
            'success' => true,
            'message' => "CR Name Updated Successfully",
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $conference_room = ConferenceRoom::find($id);
        $conference_room->delete();
        return response()->json(array(
            'success' => true,
            'message' => "deleted",
            "data" => $id,
        ), 200);

    }

    public function activeMeetings($id)
    {
        $today = Carbon::now()->startOfDay();

        $meetings = Meeting::where('conference_room_id', $id)
            ->where('deleted_at', null)
            ->where('meeting_date', $today)
            ->orderBy('meeting_date', 'ASC')
            ->with('user', 'conferenceRoom')
            ->get();

        $cr_room = ConferenceRoom::find($id);
        return view('admin.conference_room.active-meetings')->with([
            'cr_room' => $cr_room,
            'meetings' => $meetings,
            'page' => 'cr_room',
        ]);
    }

}
