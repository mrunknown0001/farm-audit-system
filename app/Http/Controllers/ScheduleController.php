<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;

class ScheduleController extends Controller
{
    // Schedule
    public function schedule()
    {
    	$sched = Schedule::find(1);

    	return view('admin.schedule-settings', compact('sched'));
    }


    public function updateSchedule(Request $request)
    {
    	$request->validate([
    		'time_in' => 'required',
    		'time_out' => 'required',
    	]);

    	$sched = Schedule::find(1);
    	$sched->timein = $request->time_in;
    	$sched->timeout = $request->time_out;
    	$sched->save();

    	return redirect()->back()->with('success', 'Schedule Updated!');
    }
}
