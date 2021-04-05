<?php

namespace App\Http\Controllers\EmployeeModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('employee.home')->with([
            "page" => "dashboard"
        ]);
    }
}
