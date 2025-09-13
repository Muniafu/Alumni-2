<nav x-data="{ open: false, openNotifications: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->is_approved)
                            @if(auth()->user()->hasRole('admin'))
                                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                    {{ __('Admin Dashboard') }}
                                </x-nav-link>
                                <x-nav-link :href="route('admin.pending-approvals')" :active="request()->routeIs('admin.pending-approvals')">
                                    {{ __('Pending Approvals') }}
                                </x-nav-link>
                                <x-nav-link :href="route('admin.user-management')" :active="request()->routeIs('admin.user-management')">
                                    {{ __('User Management') }}
                                </x-nav-link>
                            @elseif(auth()->user()->hasRole('alumni'))
                                <x-nav-link :href="route('alumni.dashboard')" :active="request()->routeIs('alumni.dashboard')">
                                    {{ __('Alumni Dashboard') }}
                                </x-nav-link>
                                <x-nav-link :href="route('alumni.profile')" :active="request()->routeIs('alumni.profile')">
                                    {{ __('My Profile') }}
                                </x-nav-link>
                            @elseif(auth()->user()->hasRole('student'))
                                <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                                    {{ __('Student Dashboard') }}
                                </x-nav-link>
                                <x-nav-link :href="route('student.profile')" :active="request()->routeIs('student.profile')">
                                    {{ __('My Profile') }}
                                </x-nav-link>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side: Notifications + Settings -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <!-- Notification Dropdown -->
                    <div class="relative ms-3">
                        <button @click="openNotifications = !openNotifications"
                                class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 inline-block w-5 h-5 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full text-xs text-white items-center justify-center">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <div x-show="openNotifications"
                             @click.away="openNotifications = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-700">Notifications</p>
                                </div>

                                <div class="max-h-64 overflow-y-auto">
                                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                        <a href="{{ $notification->data['url'] ?? '#' }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 mark-as-read"
                                           data-id="{{ $notification->id }}">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 pt-0.5">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">{{ $notification->data['message'] }}</p>
                                                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-3 text-center text-sm text-gray-500">
                                            No new notifications
                                        </div>
                                    @endforelse
                                </div>

                                <div class="border-t border-gray-200">
                                    <a href="{{ route('notifications.all') }}"
                                       class="block px-4 py-2 text-sm text-center text-blue-600 hover:bg-gray-100">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Settings Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(auth()->user()->hasRole('admin'))
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Settings') }}
                                </x-dropdown-link>
                            @elseif(auth()->user()->hasRole('alumni'))
                                <x-dropdown-link :href="route('alumni.profile')">
                                    {{ __('My Profile') }}
                                </x-dropdown-link>
                            @elseif(auth()->user()->hasRole('student'))
                                <x-dropdown-link :href="route('student.profile')">
                                    {{ __('My Profile') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->is_approved)
                    @if(auth()->user()->hasRole('admin'))
                        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Dashboard') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.pending-approvals')" :active="request()->routeIs('admin.pending-approvals')">
                            {{ __('Pending Approvals') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.user-management')" :active="request()->routeIs('admin.user-management')">
                            {{ __('User Management') }}
                        </x-responsive-nav-link>
                    @elseif(auth()->user()->hasRole('alumni'))
                        <x-responsive-nav-link :href="route('alumni.dashboard')" :active="request()->routeIs('alumni.dashboard')">
                            {{ __('Alumni Dashboard') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('alumni.profile')" :active="request()->routeIs('alumni.profile')">
                            {{ __('My Profile') }}
                        </x-responsive-nav-link>
                    @elseif(auth()->user()->hasRole('student'))
                        <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                            {{ __('Student Dashboard') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('student.profile')" :active="request()->routeIs('student.profile')">
                            {{ __('My Profile') }}
                        </x-responsive-nav-link>
                    @endif
                @endif
            @else
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(auth()->user()->hasRole('admin'))
                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Settings') }}
                        </x-responsive-nav-link>
                    @elseif(auth()->user()->hasRole('alumni'))
                        <x-responsive-nav-link :href="route('alumni.profile')">
                            {{ __('My Profile') }}
                        </x-responsive-nav-link>
                    @elseif(auth()->user()->hasRole('student'))
                        <x-responsive-nav-link :href="route('student.profile')">
                            {{ __('My Profile') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
