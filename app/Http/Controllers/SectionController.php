<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Section;

class SectionController extends Controller
{
    public function index() {

        $user = auth()->user();
        
        $sections = Section::all();

        return view('admin.section', [
            'sections' => $sections,
            'user' => $user
        ]);
        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section' => 'required|string|max:25',
        ]);

        try {
            $section = new Section();

            $section->fill($validatedData);

            $section->save();

            return redirect()->back()->with('succes', 'Section created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create section: ');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'section' => 'required|string|max:25',
        ]);

        try {
            $section = Section::findOrFail($id);

            $section->update($validatedData);

            return redirect()->back()->with('success', 'Section updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update section');
        }
    }

    public function destroy($id)
    {
        try {
            $section = Section::findOrFail($id);

            $section->delete();

            return redirect()->back()->with('succes', 'Section deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete section: ');
        }
    }
}
