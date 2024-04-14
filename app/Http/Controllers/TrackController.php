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
    
            return redirect()->back()->with('success', 'Track created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create track. Please try again.');
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
    
            return redirect()->back()->with('success', 'Track updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update track. Please try again.');
        }
    }

    public function destroy($id) {

        try {
            $track = Track::findOrFail($id);
    
            $track->delete();
    
            return redirect()->back()->with('success', 'Track deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete track. Please try again.');
        }

    }
}
