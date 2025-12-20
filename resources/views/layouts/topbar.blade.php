<div class="navbar-custom d-flex justify-content-between align-items-center">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Project Name -->
        <div class="navbar-brand text-primary">
            FYP-GATE
        </div>

        <!-- Notifications -->
        <div class="dropdown position-relative">
            <a class="btn btn-secondary dropdown-toggle position-relative" 
               href="#" 
               id="notificationsDropdown" 
               role="button" 
               data-bs-toggle="dropdown" 
               aria-expanded="false">
                <i class="uil-bell"></i>
                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                        {{ $unreadNotificationsCount }}
                    </span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                @if(isset($notifications) && count($notifications) > 0)
                    @foreach($notifications as $notification)
                        <li>
                            <a class="dropdown-item" href="{{ route('notifications.markAsRead', $notification->id) }}">
                                {{ $notification->message }}
                                <span class="text-muted small d-block">
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                @else
                    <li class="dropdown-item text-muted">No notifications</li>
                @endif
            </ul>
        </div>

        <!-- Logout Button -->
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="uil-signout-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>
