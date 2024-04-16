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
use App\Models\studentAttendance;

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
            'lrn_no' => 'required|string|max:15', 
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'ctn_no' => 'required|string|max:15', 
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
            $numberPart = (int) substr($latestStudentID->student_no, 0, 4);
            
            $numberPart++;
            
            $yearPart = substr($latestStudentID->student_no, 4, 2);
        } else {
            $numberPart = 1;
            
            $yearPart = date('y');
        }
    
        $newStudentID = str_pad($numberPart, 4, '0', STR_PAD_LEFT) . $yearPart;
    
        return $newStudentID;
    }

    public function update(Request $request, $id) {
        try {
            $student = Student::findOrFail($id);
            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'lrn_no' => 'required|string|max:15',
                'gender' => 'required|string',
                'birthdate' => 'required|date',
                'ctn_no' => 'required|string|max:15',
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
            $student = Student::findOrFail($id);

            $student->delete();

            return redirect()->back()->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

    public function studentDetail() {
        
        $studentAttendances = studentAttendance::orderBy('created_at', 'asc')->paginate(5);
        $studentAttendances = studentAttendance::leftJoin('students', 'student_attendances.user_id', '=', 'students.user_id')
                                    ->leftJoin('student_i_d_s as stdIDS', 'students.user_id', '=', 'stdIDS.std_id')
                                    ->select(
                                        'student_attendances.*',
                                        'students.name as student_name',
                                        'students.lrn_no as student_lrn_no',
                                        'stdIDS.student_no as student_no',
                                    )
                                    ->get();
        
        $tracks = Track::all();
        $sections = Section::all(); 
        $gr_levels = GradeLevel::all();
        $genders = Gender::all();
    
        return view('welcome', [
            'studentAttendances' => $studentAttendances,
            'tracks' => $tracks,
            'sections' => $sections,
            'gr_levels' => $gr_levels,
            'genders' => $genders
        ]);
    }

    public function studentDetailStore(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'student_id' => 'required|matches_student_id',
            'desktop_time' => 'required|string' // Add validation for desktop time
        ]);

        // Retrieve the student record based on the provided student ID
        $studentID = $validatedData['student_id'];
        $student = StudentID::where('student_no', $studentID)->first();
        
        // Check if a student with the provided ID exists
        if ($student) {
            // Create a new instance of studentAttendance
            $attendance = new studentAttendance();
            
            // Add the authenticated user's ID to the validated data
            $attendance->user_id = $student->std_id;
            
            // Format the desktop time into MySQL datetime format
            $attendance->time_in = date('Y-m-d H:i:s', strtotime($validatedData['desktop_time']));
            
            // Save the attendance record
            $attendance->save();

            return redirect()->back()->with('success', 'Attendance recorded successfully');
        } else {
            return redirect()->back()->with('error', 'Student with ID ' . $studentID . ' not found.');
        }
    }

}
