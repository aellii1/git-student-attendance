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

            flash()->success('Success','Section Record has been created successfully !');

            return redirect()->route('sections')->with('success');
        } catch (\Exception $e) {
            flash()->error('Error','Track Record has failed to create !');

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

            flash()->success('Success','Section Record has been updated successfully !');

            return redirect()->route('sections')->with('success');
        } catch (\Exception $e) {
            flash()->error('Error','Section Record has failed to update !');

            return redirect()->route('sections')->with('error');
        }
    }

    public function destroy($id)
    {
        try {
            $section = Section::findOrFail($id);

            $section->delete();

            flash()->success('Success','Section Record has been deleted successfully !');

            return redirect()->route('sections')->with('success');
        } catch (\Exception $e) {
            flash()->error('Error','Section Record has failed to delete !');

            return redirect()->route('sections')->with('error');
        }
    }
}
