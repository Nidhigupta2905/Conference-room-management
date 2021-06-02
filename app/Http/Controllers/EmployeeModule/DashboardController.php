<?php

namespace App\Http\Controllers\EmployeeModule;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        return view('employee.home')->with([
            "page" => "dashboard",
        ]);
    }

    public function getChartData()
    {
        $date = Carbon::now()->subDays(2);
        $chartData = Meeting::whereDate('meeting_date', '>=', $date)
            ->orderBy('meeting_date', 'ASC')
            ->get();

        return response()->json([
            'chartData' => $chartData,
        ]);
    }
}
