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
        $students = Student::leftJoin('tracks', 'students.track', '=', 'tracks.id')
                            ->leftJoin('sections', 'students.section', '=', 'sections.id')
                            ->leftJoin('grade_levels as grLevel', 'students.gr_lvl', '=', 'grLevel.id')
                            ->leftJoin('student_i_d_s as studentNo', 'students.user_id', '=', 'studentNo.std_id')
                            ->select('students.*',
                            'tracks.track as std_track',
                            'tracks.strand as std_strand',
                            'sections.section as std_section',
                            'grLevel.grade as std_grade',
                            'studentNo.student_no as std_no'
                            )
                            ->get();
        
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
            'lrn_no' => 'required|string|max:11', 
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'ctn_no' => 'required|string|max:11', 
            'email' => 'required|email|unique:students,email',
            'section' => 'required|string|max:255',
            'track' => 'required|string|max:255',
            'gr_lvl' => 'required|string|max:255',
        ]);

        $validatedData['user_id'] = Str::uuid();

        $studentNo = $this->generateStudentNo();

        $student = Student::create($validatedData);

        StudentID::create([
            'student_no' => $studentNo,
            'std_id' => $student->user_id,
        ]);

        return redirect()->back()->with('success', 'Student created successfully');
    }

    private function generateStudentNo() {
        $latestStudentID = StudentID::latest('student_no')->first();
    
        if ($latestStudentID) {
            $parts = explode('-', $latestStudentID->student_no);
            $number = isset($parts[0]) ? $parts[0] + 1 : 1;
            $year = isset($parts[1]) ? $parts[1] : date('Y');
    
            $newStudentID = str_pad($number, 4, '0', STR_PAD_LEFT) . $year;
    
            return $newStudentID;
        } else {
            return '000124'; 
        }
    }

    public function update(Request $request, $id) {
        try {

            $student = Student::findOrFail($id);
            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|string',
                'birthdate' => 'required|date',
                'ctn_no' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $student->id,
                'section' => 'required|string|max:255',
                'track' => 'required|string|max:255',
                'gr_lvl' => 'required|string|max:255',
            ]);
    
            $student->update($validatedData);
    
            return redirect()->back()->with('success', 'Student updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update student: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Find the student by ID
            $student = Student::findOrFail($id);

            // Delete the student
            $student->delete();

            // Optionally, you can return a success message
            return redirect()->back()->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            // If an error occurs, return an error message
            return redirect()->back()->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

}
