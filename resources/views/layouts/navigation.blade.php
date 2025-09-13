<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo style="height:40px; width:auto;" />
        </a>

        <!-- Hamburger / Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    @if(auth()->user()->is_approved)
                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.pending-approvals') ? 'active' : '' }}" href="{{ route('admin.pending-approvals') }}">Pending Approvals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.user-management') ? 'active' : '' }}" href="{{ route('admin.user-management') }}">User Management</a>
                            </li>
                        @elseif(auth()->user()->hasRole('alumni'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('alumni.dashboard') ? 'active' : '' }}" href="{{ route('alumni.dashboard') }}">Alumni Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('alumni.profile') ? 'active' : '' }}" href="{{ route('alumni.profile') }}">My Profile</a>
                            </li>
                        @elseif(auth()->user()->hasRole('student'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">Student Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}" href="{{ route('student.profile') }}">My Profile</a>
                            </li>
                        @endif
                    @endif
                @endauth
            </ul>

            <!-- Right Side: Notifications & User Dropdown -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                @auth
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link position-relative" href="#" id="navbarNotifications" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarNotifications" style="min-width:300px;">
                            <li class="dropdown-header">Notifications</li>
                            @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-start" href="{{ $notification->data['url'] ?? '#' }}">
                                        <div>
                                            <strong>{{ $notification->data['message'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="dropdown-item text-center text-muted">No new notifications</li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="{{ route('notifications.all') }}">View all notifications</a></li>
                        </ul>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                            @if(auth()->user()->hasRole('admin'))
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Settings</a></li>
                            @elseif(auth()->user()->hasRole('alumni'))
                                <li><a class="dropdown-item" href="{{ route('alumni.profile') }}">My Profile</a></li>
                            @elseif(auth()->user()->hasRole('student'))
                                <li><a class="dropdown-item" href="{{ route('student.profile') }}">My Profile</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Guest Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
