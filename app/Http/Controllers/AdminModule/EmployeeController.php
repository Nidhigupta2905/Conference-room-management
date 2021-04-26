<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::all();
        return view('admin.employee.index')->with([
            'employees' => $employees,
            'page' => 'employees',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.employee.create')->with([
            'page' => 'employees',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validation
        Validator::make($request->all(), [
            'employee_name' => 'required|max:255',
            'employee_email' => 'required|unique:users,email',
        ])->validate();

        $employees = new User();

        $employees->name = $request->employee_name;
        $employees->email = $request->employee_email;
        $employees->role_id = User::ROLES['EMPLOYEE'];
        $employees->save();

        $request->session()->flash('success', 'Employee added successfully');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = User::find($id);
        return view('admin.employee.show')->with([
            'employee' => $employee,
            'page' => 'employees',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = User::find($id);
        return view('admin.employee.update')->with([
            'employee' => $employee,
            'page' => 'employees',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'employee_email' => 'required|unique:users,email',
        ])->validate();
        $employee = User::find($id);
        $employee->email = $request->employee_email;
        $employee->save();

        $request->session()->flash('success', 'Employee Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        User::where('id', $id)->delete();
        $request->session()->flash('success', 'Employee Deleted Successfully');
        return redirect()->back();
    }

    public function meetingHistory()
    {
        $meetings = Meeting::all();

        return view('admin.employee.meeting-history')->with([
            'page' => 'meetingHistory',
            'meetings' => $meetings,
        ]);
    }
}
