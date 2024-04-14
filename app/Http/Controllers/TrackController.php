<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Track;
use App\Http\Requests;
use RealRashid\SweetAlert\Facades\Alert;

class TrackController extends Controller
{
   
    public function index()
    {
        
        return view('admin.track')
            ->with(['tracks'=> Track::all()]);
    }

    public function store(Request $request)
    {
        $request->validated();

        $tracks = new Employee;
        $tracks->track = $request->tracks;
        $tracks->strand = $request->strands;
        $tracks->save();

        flash()->success('Success','Track Record has been created successfully !');

        return redirect()->route('tracks.index')->with('success');
    }

 
    public function update(EmployeeRec $request, Employee $tracks)
    {
        $request->validated();

        $tracks->name = $request->name;
        $tracks->position = $request->position;
        $tracks->email = $request->email;
        $tracks->pin_code = bcrypt($request->pin_code);
        $tracks->save();

        if ($request->schedule) {

            $tracks->schedules()->detach();

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $tracks->schedules()->attach($schedule);
        }

        flash()->success('Success','Employee Record has been Updated successfully !');

        return redirect()->route('employees.index')->with('success');
    }


    public function destroy(Employee $tracks)
    {
        $tracks->delete();
        flash()->success('Success','Employee Record has been Deleted successfully !');
        return redirect()->route('employees.index')->with('success');
    }
}
