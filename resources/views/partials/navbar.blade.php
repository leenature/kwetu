@php
    $role = auth()->user()->role ?? 'Owner';

    $roleClass = match ($role) {
        'Super Admin' => 'super-admin',
        'Owner' => 'owner',
        'Manager' => 'manager',
        'Accountant' => 'accountant',
        'Caretaker' => 'caretaker',
        default => 'owner',
    };
@endphp

<nav class="app-navbar">
    <div class="nav-left">
        <button id="sidebarToggle" class="nav-icon" type="button"
                aria-label="Toggle sidebar" aria-expanded="true">
            <i class="bi bi-list"></i>
        </button>

        <div>
            <span class="nav-eyebrow">Workspace</span>
            <h1 class="nav-title">@yield('title', 'Dashboard')</h1>
        </div>
    </div>

    <label class="nav-search">
        <i class="bi bi-search"></i>
        <input type="search" placeholder="Search properties, tenants, payments...">
        <kbd>⌘ K</kbd>
    </label>

    <div class="nav-right">
        <button id="themeToggle" class="nav-icon" type="button" aria-label="Toggle theme">
            <i class="bi bi-moon-stars"></i>
        </button>

        <a href="{{ route('settings.index') }}" class="nav-icon" aria-label="Settings">
            <i class="bi bi-gear"></i>
        </a>

        <div class="notification-menu">
            <button id="notificationToggle" class="nav-icon" type="button" aria-label="Notifications" aria-expanded="false">
                <i class="bi bi-bell"></i>
                @if(auth()->user()->unreadNotifications()->count())<span class="notification-dot"></span>@endif
            </button>
            <div id="notificationDropdown" class="notification-dropdown">
                <div class="notification-heading"><strong>Notifications</strong><small>Recent workspace activity</small></div>
                <div class="notification-list">
                    @forelse(auth()->user()->notifications()->latest()->limit(8)->get() as $notification)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button class="notification-item {{ is_null($notification->read_at) ? 'unread' : '' }}" type="submit">
                                <i class="bi {{ $notification->data['icon'] ?? 'bi-bell-fill' }}"></i>
                                <span><strong>{{ $notification->data['title'] ?? 'Workspace update' }}</strong><small>{{ $notification->data['message'] ?? '' }}</small><em>{{ $notification->created_at->diffForHumans() }}</em></span>
                            </button>
                        </form>
                    @empty
                        <p class="notification-empty">You are all caught up.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="profile-menu">
            <button id="profileMenuToggle" class="profile-summary" type="button"
                    aria-expanded="false">
                <span class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>

                <span class="profile-details">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small class="role-badge {{ $roleClass }}">{{ $role }}</small>
                </span>

                <i class="bi bi-chevron-down"></i>
            </button>

            <div id="profileDropdown" class="profile-dropdown">
                <div class="profile-dropdown-user">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span class="role-badge {{ $roleClass }}">{{ $role }}</span>
                </div>

                <a href="{{ route('settings.index') }}">
                    <i class="bi bi-gear"></i>
                    Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <i class="bi bi-box-arrow-right"></i>
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
