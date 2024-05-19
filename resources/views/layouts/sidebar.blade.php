<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                @if(Auth::user()->hasRole('admin'))
                <li class="menu-title">Main</li>
                <li class="">
                    <a href="{{ route('admin') }}" class="waves-effect {{ request()->is("admin") || request()->is("admin/*") ? "mm active" : "" }}">
                        <i class="ti-home"></i> <span> Dashboard </span>
                    </a>
                </li>
                <!-- Admin Sidebar Menu -->
                <li>
                    <a href="/students" class="waves-effect {{ request()->is("students") || request()->is("students/*") ? "mm active" : "" }}">
                        <i class="ti-user"></i><span> Student </span>
                    </a>
                </li>
                <li class="menu-title">Management</li>
                <li class="">
                    <a href="/student-logs" class="waves-effect {{ request()->is("student-logs") || request()->is("student-logs/*") ? "mm active" : "" }}">
                        <i class="ti-calendar"></i> <span> Attendance Logs </span>
                    </a>
                </li>
                <li class="">
                    <a href="/tracks" class="waves-effect  {{ request()->is("tracks") || request()->is("tracks/*") ? "mm active" : "" }}">
                        <i class="ti-pin-alt"></i> <span> Track </span>
                    </a>
                </li>
                <li class="">
                    <a href="/sections" class="waves-effect  {{ request()->is("sections") || request()->is("sections/*") ? "mm active" : "" }}">
                        <i class="ti-stamp"></i> <span> Section </span>
                    </a>
                </li>
                @elseif(Auth::user()->hasRole('faculty'))
                <li class="menu-title">Main</li>
                <li class="">
                    <a href="{{ route('faculty') }}" class="waves-effect {{ request()->is("faculty") || request()->is("faculty/*") ? "mm active" : "" }}">
                        <i class="ti-home"></i> <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="ti-user"></i><span> Student </span>
                    </a>
                </li>
                <li class="">
                    <a href="#" class="waves-effect">
                        <i class="ti-calendar"></i> <span> Attendance Logs </span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->