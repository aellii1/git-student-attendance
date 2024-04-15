<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Student;
use App\Models\StudentID;
use App\Models\Track;
use App\Models\Section;
use App\Models\GradeLevel;
use App\Models\Gender;

class StudentController extends Controller
{
    public function index() {

        $user = auth()->user();
        
        $students = Student::all();
        $tracks = Track::all();
        $sections = Section::all(); 
        $gr_levels = GradeLevel::all();
        $genders = Gender::all();

        return view('admin.student', [
            'students' => $students,
            'user' => $user,
            'tracks' => $tracks,
            'sections' => $sections,
            'gr_levels' => $gr_levels,
            'genders' => $genders
        ]);
        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'ctn_no' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'section' => 'required|string|max:255',
            'track' => 'required|string|max:255',
            'gr_lvl' => 'required|string|max:255',
        ]);

        $validatedData['user_id'] = Str::uuid();

        $student = Student::create($validatedData);

        return redirect()->back()->with('success', 'Student created successfully');
    }

}
