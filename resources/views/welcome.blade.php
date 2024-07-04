@include('layouts.welcome')
@include('layouts.welcome-header')

    <style>
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }
    </style>
  
    <div class="main-content p-5 ">
        <div class="container">
            <div class="content-header p-1 rounded-top shadow mb-2" style="background-color: #E8E7E7;">
                <div class="row mx-2">
                    <div class="col-md-6 font-weight-bold text-dark" align="left">
                        {{ strtoupper('attendance') }}
                    </div>
                    <div class="col-md-6" align="right">
                        <div class="digital-clock pr-4 mr-1">
                            <img src="{{ asset('svg/clock.svg') }}" alt="clock">
                            <span id="time" class="display-5 font-weight-bold text-dark"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body rounded-bottom" style="
                min-height: 60vh; 
                background-color: #F3F3F3; 
                background-image: url('../assets/images/voctech-bg.png'); 
                background-size: 30%; 
                background-repeat: no-repeat; 
                background-position: center;
            ">

                <div class="row justify-content-center">
                    <div class="col-md-3 p-3 flex-center" align="left">
                        <div class="row">
                            @if(!$studentAttendances)
                                <img src="{{ route('student.profile', ['id' => $studentAttendances]) }}" class="border border-secondary" width="80%" alt="Student Profile">
                                @else
                                <img src="{{ asset('assets/images/profile.png') }}" class="border border-secondary" width="80%" alt="Default Profile">
                            @endif
                            <div class="col-md-12 offset-md-1 pl-2 pt-2">
                            <form id="attendanceForm" action="{{ route('student.detail.store') }}" method="POST">
                                @csrf
                                <input type="number" name="student_id" class="rounded-pill border border-secondary" style="text-align: center; outline: none;" placeholder="Input Your ID No" required />
                                <input type="hidden" id="desktopTime" name="desktop_time">
                                <input type="hidden" id="actionType" name="action_type">
                                <div class="submit-btn px-5 mx-1 pt-1">
                                    <button type="button" class="btn-sm btn-success rounded-pill" onclick="submitForm('time_in')">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 p-3">
                        <div class="detail-header text-dark font-weight-bold rounded-top shadow p-1 mb-2" style="background-color: #EAE9E9;">
                            {{ strtoupper('details') }}
                        </div>
                        <div class="detail-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Name:
                                        </th>
                                        <th>
                                            LRN No:
                                        </th>
                                        <th>
                                            ID No:
                                        </th>
                                        <th>
                                            Time In:
                                        </th>
                                        <th>
                                            Time Out:
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentAttendances as $student)
                                    @include('student-detail')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- clock script -->
    <script>
        function updateTime() {
            const now = new Date();
            const daysOfWeek = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
            const dayOfWeek = daysOfWeek[now.getDay()];
            let hours = now.getHours();
            const amPM = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12; // Convert to 12-hour format
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds} ${amPM} ${dayOfWeek}`;
            document.getElementById('time').textContent = timeString;
        }

            // Update time every second
            setInterval(updateTime, 1000);

            // Initial call to set time immediately on page load
            updateTime();
    </script>

    <script>
        function getCurrentDesktopTime() {
            return new Date().toLocaleString();
        }
        
        function submitForm(actionType) {
            var desktopTime = getCurrentDesktopTime();

            // set value to hidden inputs
            document.getElementById('desktopTime').value = desktopTime;
            document.getElementById('actionType').value = actionType;

            // logs for data before submission
            console.log("Submitting for with data:");
            console.log("Student ID:", document.getElementsByName('student_id')[0].value);
            console.log("Desktop Time:", desktopTime);
            console.log("Action Type:", actionType);

            // submit form
            document.getElementById('attendanceForm').submit();
        }
    </script>