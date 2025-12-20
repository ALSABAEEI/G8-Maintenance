<div class="left-side-menu">
    <div class="h-100" id="left-side-menu-container" data-simplebar>
        <ul class="metismenu side-nav">
            <!-- Menu Title -->
            <li class="side-nav-title">Menu</li>

            <!-- Dashboard Menu Item -->
            <li class="side-nav-item">
                <a href="{{ route(auth()->user()->Role . '.dashboard') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <!-- Admin-Specific Links -->
            @if(auth()->user()->Role === 'admin')
                <li class="side-nav-item">
                    <a href="{{ route('users.index') }}" class="side-nav-link">
                        <i class="uil-users-alt"></i>
                        <span> Manage Users </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('quota.index') }}" class="side-nav-link">
                        <i class="uil-cog"></i>
                        <span> Manage Quota </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('timeframes.index') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> Manage TimeFrame </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('admin.topics') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> View All Topics </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('appointments.manage') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> Manage Appointment </span>
                    </a>
                </li>
            @endif

            <!-- Supervisor-Specific Links -->
            @if(auth()->user()->Role === 'supervisor')
                <li class="side-nav-item">
                    <a href="{{ route('topics.index') }}" class="side-nav-link">
                        <i class="uil-file-plus"></i>
                        <span> Manage Topics </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('applications.index') }}" class="side-nav-link">
                        <i class="uil-check-square"></i>
                        <span> Manage Applications </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('appointments.manage') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> Manage Appointment </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('supervisor.timeframes') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> Ongoing Timeframes </span>
                    </a>
                </li>
            @endif

            <!-- Student-Specific Links -->
            @if(auth()->user()->Role === 'student')
                <li class="side-nav-item">
                    <a href="{{ route('students.view-topics') }}" class="side-nav-link">
                        <i class="uil-folder-plus"></i>
                        <span> View Topics </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('students.view-status') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> Applications Status </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('appointments.manage') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> Manage Appointment </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('student.timeframes') }}" class="side-nav-link">
                        <i class="uil-calendar-alt"></i>
                        <span> Ongoing Timeframes </span>
                    </a>
                </li>
            @endif

            <!-- Reports for Admin and Supervisor -->
            @if(auth()->user()->Role === 'admin' || auth()->user()->Role === 'supervisor')
                <li class="side-nav-item">
                    <a href="{{ route('reports.users') }}" class="side-nav-link">
                        <i class="uil-chart"></i>
                        <span> View & Generate Report </span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
