<style>
    /* Hide the "Choose File" button */
    input[type="file"]::-webkit-file-upload-button {
        display: none;
    }

    /* Hide the placeholder text */
    input[type="file"]::-webkit-file-upload-button::before {
        content: none;
    }

    /* Hide the "No file chosen" text for Firefox */
    input[type="file"]:-moz-file-broken::after {
        content: none !important;
    }

    /* Hide the "No file chosen" text for Chrome */
    input[type="file"] {
        color: transparent;
    }

    /* Hide the file name initially */
    #file-name {
        display: none;
    }
</style>

<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
            <h5 class="modal-title"><b>Add New Student</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            
            <div class="modal-body">

                <div class="card-body text-left">

                    <form id="student-form" method="POST" action="{{ route('students.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="picture" class="btn btn-secondary">Upload Photo</label>
                            <input type="file" id="picture" name="picture" accept=".png, .jpg, .jpeg" required>
                            <input type="text" class="form-control" id="file-input" readonly>
                            <span class="form-control" id="file-name"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name | e.g. John Doe" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="lrn_no">LRN No.</label>
                            <input type="number" class="form-control" id="lrn_no" name="lrn_no" placeholder="Enter LRN No." autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender">
                                <option value="">-- Select Gender --</option>
                                @foreach($genders as $gender)
                                    <option value="{{ $gender->id }}">{{ strtoupper($gender->gender) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Enter Birthdate" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="ctn_no">Contact No.</label>
                            <input type="number" class="form-control" id="ctn_no" name="ctn_no" maxlength="11" placeholder="Enter Contact No." autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" autofocus required />
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <select class="form-control" name="section" id="section">
                                <option value="">-- Select Section --</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ strtoupper($section->section) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="track">Track</label>
                            <select class="form-control" name="track" id="track">
                                <option value="">-- Select Track --</option>
                                @foreach($tracks as $track)
                                    <option value="{{ $track->id }}">{{ strtoupper($track->track) }} - {{ strtoupper($track->strand) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gr_lvl">Grade Level</label>
                            <select class="form-control" name="gr_lvl" id="gr_lvl">
                                <option value="">-- Select Grade Level --</option>
                                @foreach($gr_levels as $grlvl)
                                    <option value="{{ $grlvl->id }}">{{ strtoupper($grlvl->grade) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-danger waves-effect m-l-5" data-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</div>
</div>

<script>
   
   document.addEventListener("DOMContentLoaded", function() {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Get the form element
    const form = document.getElementById('student-form');
    if (!form) {
        console.error('Form with ID "student-form" not found.');
        return;
    }

    // Listen for form submission
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form); // Collect all form data

        // Include CSRF token
        formData.append('_token', csrfToken);

        // Send the form data to the server using AJAX
        $.ajax({
            url: '/students', // Update the URL if necessary
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Handle success
                window.location.href = '/students'; // Redirect or update the page as needed
            },
            error: function (xhr, status, error) {
                // Handle error
                const errors = xhr.responseJSON.errors;
                let errorMessages = '';
                for (const key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        errorMessages += errors[key].join(', ') + '\n';
                    }
                }
            }
        });
    });

    // File input display logic
    const fileInput = document.getElementById('picture');
    const fileNameSpan = document.getElementById('file-name');
    const fileInputDisplay = document.getElementById('file-input');

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                const file = this.files[0];
                fileNameSpan.textContent = file.name;
                fileNameSpan.style.display = 'inline-block';
                fileInputDisplay.style.display = 'none';
            } else {
                fileNameSpan.textContent = '';
                fileNameSpan.style.display = 'none';
                fileInputDisplay.style.display = 'block';
            }
        });
    } else {
        console.error('File input with ID "picture" not found.');
    }
});

</script>