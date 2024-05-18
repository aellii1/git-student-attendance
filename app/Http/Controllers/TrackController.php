<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Track;
use App\Http\Requests;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TrackController extends Controller
{
    public function index() {

        $user = auth()->user();
        
        $tracks = Track::all();
        
        return view('admin.track', [
            'tracks' => $tracks,
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'track' => 'required|string|max:10',
            'strand' => 'required|string|max:25'
        ]);
    
        try {
            $track = Track::create($validatedData);

            flash()->success('Success','Track Record has been created successfully !');
    
            return redirect()->route('tracks')->with('success');
        } catch (\Exception $e) {
            flash()->error('Error','Track Record has failed to create !');
            
            return redirect()->route('tracks')->with('error');
        }
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'track' => 'required|string|max:10',
            'strand' => 'required|string|max:25'
        ]);
    
        try {
            $track = Track::findOrFail($id);
    
            $track->update($validatedData);

            flash()->success('Success','Track Record has been updated successfully !');
    
            return redirect()->route('tracks')->with('success');
        } catch (\Exception $e) {
            flash()->error('Success','Track Record has failed to update !');

            return redirect()->route('tracks')->with('error');
        }
    }

    public function destroy($id) {

        try {
            $track = Track::findOrFail($id);
    
            $track->delete();
    
            flash()->success('Success','Track Record has been deleted successfully !');

            return redirect()->route('tracks')->with('success');
        } catch (\Exception $e) {
            flash()->error('Success','Track Record has failed to delete !');

            return redirect()->route('tracks')->with('error');
        }

    }
}
