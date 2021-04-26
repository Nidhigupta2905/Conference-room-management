<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use App\Models\ConferenceRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'conference_room_name' => 'required|unique:conference_rooms,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(),
                'message' => 'validation error',
            ], 422);
        }

        $conference_room = new ConferenceRoom;
        $conference_room->name = $request->conference_room_name;
        $conference_room->save();

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
        $cr_room = ConferenceRoom::find($id);
        return view('admin.conference_room.show')->with([
            'cr_room' => $cr_room,
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
            'conference_room_name' => 'required|unique:conference_rooms,name',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'errors'=>$validator->errors()->all(),
                'message'=>'validation error'
            ], 422);
        }

        $cr_room = ConferenceRoom::find($id);
        $cr_room->name = $request->conference_room_name;
        $cr_room->save();
        return response()->json([
            'success'=>true,
            'message'=>"CR Name Updated Successfully"
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
        ConferenceRoom::where('id', $id)->delete();
        $request->session()->flash("success", "Room Deleted Successfully");
        return redirect()->back();
    }


}
