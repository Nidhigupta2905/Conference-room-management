<?php

namespace App\Http\Controllers\AdminModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\employee\StoreFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function store(StoreFormRequest $request)
    {
        $employees = User::create($request->getData());

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
        try{
            $employee = User::find($id);
            $employee->email = $request->employee_email;
            $employee->save();
    
            $request->session()->flash('success', 'Employee Updated Successfully');
            return redirect()->back();
        }catch(\Exception $e){
            return redirect()->back()->withErrors([
                'email'=>"Email Cannot be Empty"
            ]);
        }
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

}
