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

        // Validate student data
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
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        
        // Check if an image file is uploaded
        if ($request->hasFile('picture')) {
            // Validate and upload the image
            $path = $request->file('picture')->store('/public'); // Store in storage/app/public directory
            $relativePath = str_replace('public/', '', $path); 
            $validatedData['picture'] = $relativePath; 
        }
        
        // Generate UUID for user_id
        $validatedData['user_id'] = Str::uuid();
        
        // Generate student number
        $studentNo = $this->generateStudentNo();
        
        // Create the student record
        $student = Student::create($validatedData);
        
        // Create StudentID record
        StudentID::create([
            'student_no' => $studentNo,
            'std_id' => $student->user_id,
        ]);

        // Flash message
        flash()->success('Success','Student Record has been created successfully !');

        return redirect()->route('students')->with('success');
    }

    // generate student no
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

            flash()->success('Success','Student Record has been Updated successfully !');

            return redirect()->route('students')->with('success');
        } catch (\Exception $e) {
            flash()->error('Error','Student Record has failed to update !');

            return redirect()->route('students')->with('error');
        }
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        flash()->success('Success','Student Record deleted successfully !');

        return redirect()->route('students')->with('success');
    }

    public function studentDetail() {

        $studentAttendances = studentAttendance::paginate(4);
        
        $studentAttendances = studentAttendance::leftJoin('students', 'student_attendances.user_id', '=', 'students.user_id')
                                    ->leftJoin('student_i_d_s as stdIDS', 'students.user_id', '=', 'stdIDS.std_id')
                                    ->select(
                                        'student_attendances.*',
                                        'students.name as student_name',
                                        'students.lrn_no as student_lrn_no',
                                        'stdIDS.student_no as student_no',
                                    )
                                    ->orderBy('time_in', 'DESC')
                                    ->paginate(5);
        
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

        $validatedData = $request->validate([
            'student_id' => 'required|matches_student_id',
            'desktop_time' => 'required|string' 
        ]);

        $studentID = $validatedData['student_id'];
        $student = StudentID::where('student_no', $studentID)->first();
        
        if ($student) {

            $attendance = new studentAttendance();
            
            $attendance->user_id = $student->std_id;
            
            $attendance->time_in = date('Y-m-d H:i:s', strtotime($validatedData['desktop_time']));
            
            $attendance->save();

            return redirect()->back()->with('success', 'Attendance recorded successfully');
        } else {
            return redirect()->back()->with('error', 'Student with ID ' . $studentID . ' not found.');
        }
    }

    public function student_logs() {

        $user = auth()->user();

        $student_logs = studentAttendance::get();
        $std_logs = Student::get();
        $std_id = StudentID::get();

        $student_logs = studentAttendance::leftJoin('students','student_attendances.user_id', '=', 'students.user_id')
                                            ->leftJoin('student_i_d_s as student_id','students.user_id', '=', 'student_id.std_id')
                                            ->leftJoin('tracks','students.track', '=', 'tracks.id')
                                            ->leftJoin('sections','students.section', '=', 'sections.id')
                                            ->leftJoin('grade_levels','students.gr_lvl', '=', 'grade_levels.id')
                                            ->select('student_attendances.*',
                                                    'students.name as students_name',
                                                    'students.lrn_no as students_lrn',
                                                    'student_id.student_no',
                                                    'tracks.track as student_track',
                                                    'tracks.strand as student_strand',
                                                    'sections.section as student_section',
                                                    'grade_levels.grade as student_grade',
                                            )
                                            ->get();
        
        return view('admin.attendance-logs', [
            'student_logs' => $student_logs,
            'std_logs' => $std_logs,
            'std_id' => $std_logs,
            'user' => $user,
        ]);
    }

    public function showProfile($id)
    {
        $student_profile = Student::find($id);
        if (!$student_profile) {
            abort(404); // or redirect to a page indicating that the student ID is not found
        }

        // Assuming 'profile_image' is the column in your students table where the image path is stored
        $profileImagePath = $student->picture ?? 'assets/images/profile.png';

        return view('student.profile', ['profileImagePath' => $profileImagePath]);
    }

}
