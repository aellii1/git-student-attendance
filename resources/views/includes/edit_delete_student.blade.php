<!-- Edit -->
<div class="modal fade" id="edit{{ $student->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"><b>Edit Student Details</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('students.update', $student->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ isset($student) ? $student->name : ''}}" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="lrn_no">LRN No.</label>
                            <input type="number" class="form-control" id="lrn_no" name="lrn_no" value="{{ isset($student) ? $student->lrn_no : '' }}" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender">
                                <option value="">-- Select Gender --</option>
                                @foreach($genders as $gender)
                                    <option value="{{ $gender->id }}" {{ isset($student) && $student->gender == $gender->id ? 'selected' : '' }}>{{ strtoupper($gender->gender) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ isset($student) ? $student->birthdate : '' }}" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="ctn_no">Contact No.</label>
                            <input type="number" class="form-control" id="ctn_no" name="ctn_no" value="{{ isset($student) ? $student->ctn_no : '' }}" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ isset($student) ? $student->email : '' }}" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <select class="form-control" name="section" id="section">
                                <option value="">-- Select Section --</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ isset($student) && $student->section == $section->id ? 'selected' : '' }}>{{ strtoupper($section->section) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="track">Track</label>
                            <select class="form-control" name="track" id="track">
                                <option value="">-- Select Track --</option>
                                @foreach($tracks as $track)
                                    <option value="{{ $track->id }}" {{ isset($student) && $student->track == $track->id ? 'selected' : '' }}>{{ strtoupper($track->track) }} - {{ strtoupper($track->strand) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gr_lvl">Grade Level</label>
                            <select class="form-control" name="gr_lvl" id="gr_lvl">
                                <option value="">-- Select Grade Level --</option>
                                @foreach($gr_levels as $grlvl)
                                    <option value="{{ $grlvl->id }}" {{ isset($student) && $student->gr_lvl == $grlvl->id ? 'selected' : '' }}>{{ strtoupper($grlvl->grade) }}</option>
                                @endforeach
                            </select>
                        </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
                Update</button>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete{{ $student->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header " style="align-items: center">
               
              <h4 class="modal-title "><span class="track_id">Delete Student</span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" align="left">
                <form method="POST" action="{{ route('students.destroy', $student->id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                    
                    <div class="std_img">
                        <!-- to be followed -->
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="std_no">Student ID No</label>
                                <input type="text" class="form-control" id="std_no" name="std_no" value="{{ $student->std_no }}" readonly required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ isset($student) ? $student->name : ''}}" readonly required />
                    </div>
                    <div class="form-group">
                        <label for="lrn_no">LRN No.</label>
                        <input type="number" class="form-control" id="lrn_no" name="lrn_no" value="{{ isset($student) ? $student->lrn_no : '' }}" readonly required />
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender" {{ isset($student) && $student ? 'disabled' : '' }}>
                            <option value="">-- Select Gender --</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->id }}" {{ isset($student) && $student->gender == $gender->id ? 'selected' : '' }}>{{ strtoupper($gender->gender) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ isset($student) ? $student->birthdate : '' }}" readonly required />
                    </div>
                    <div class="form-group">
                        <label for="ctn_no">Contact No.</label>
                        <input type="number" class="form-control" id="ctn_no" name="ctn_no" value="{{ isset($student) ? $student->ctn_no : '' }}" readonly required />
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ isset($student) ? $student->email : '' }}" readonly required />
                    </div>
                    <div class="form-group">
                        <label for="section">Section</label>
                        <select class="form-control" name="section" id="section" {{ isset($student) && $student ? 'disabled' : '' }}>
                            <option value="">-- Select Section --</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ isset($student) && $student->section == $section->id ? 'selected' : '' }}>{{ strtoupper($section->section) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="track">Track</label>
                        <select class="form-control" name="track" id="track" {{ isset($student) && $student ? 'disabled' : '' }}>
                            <option value="">-- Select Track --</option>
                            @foreach($tracks as $track)
                                <option value="{{ $track->id }}" {{ isset($student) && $student->track == $track->id ? 'selected' : '' }}>{{ strtoupper($track->track) }} - {{ strtoupper($track->strand) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gr_lvl">Grade Level</label>
                        <select class="form-control" name="gr_lvl" id="gr_lvl" {{ isset($student) && $student ? 'disabled' : '' }}>
                            <option value="">-- Select Grade Level --</option>
                            @foreach($gr_levels as $grlvl)
                                <option value="{{ $grlvl->id }}" {{ isset($student) && $student->gr_lvl == $grlvl->id ? 'selected' : '' }}>{{ strtoupper($grlvl->grade) }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
