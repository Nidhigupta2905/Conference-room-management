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
        return view('admin.conference_room.create');
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
        Validator::make($request->all(), [
            'conference_room_name' => 'required',
        ])->validate();

        $conference_room = new ConferenceRoom;
        $conference_room->name = $request->conference_room_name;
        $conference_room->save();
        $request->session()->flash('success', 'CR Added successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $cr_room = ConferenceRoom::find($id);
        $cr_room->name = $request->conference_room_name;
        dd($request->conference_room_name);
        dd($cr_room->name);
        $cr_room->save();
        $request->session()->flash('success', 'Name Updated successfully');
        return redirect()->route('admin.conference_room.index');

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
