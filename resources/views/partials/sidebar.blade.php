<aside class="sidebar" id="appSidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <span class="brand-icon">
            <i class="bi bi-buildings-fill"></i>
        </span>

        <span>
            <strong>KWETU</strong>
            <small>Property Management</small>
        </span>
    </a>

    <nav class="sidebar-menu" aria-label="Main navigation">
        <p class="menu-label">Main menu</p>

        <a href="{{ route('dashboard') }}"
           class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        @if(auth()->user()->role === 'Super Admin')
            <a href="{{ route('organizations.index') }}"
               class="menu-item {{ request()->routeIs('organizations.*') ? 'active' : '' }}">
                <i class="bi bi-buildings-gear"></i>
                <span>Organizations</span>
            </a>
            <a href="{{ route('verification.index') }}" class="menu-item {{ request()->routeIs('verification.*') ? 'active' : '' }}"><i class="bi bi-patch-check-fill"></i><span>Verification</span></a>
        @endif

        @if(in_array(auth()->user()->role, ['Super Admin', 'Owner']))
            <a href="{{ route('users.index') }}"
               class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                <span>Users</span>
            </a>
        @endif

        @if(auth()->user()->canAccessModule('properties'))<a href="{{ route('properties.index') }}"
           class="menu-item {{ request()->routeIs('properties.*') ? 'active' : '' }}">
            <i class="bi bi-buildings"></i>
            <span>Properties</span>
        </a>@endif

        @if(in_array(auth()->user()->role, ['Owner', 'Super Admin']))<a href="{{ route('onboarding.index') }}" class="menu-item {{ request()->routeIs('onboarding.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-arrow-up"></i><span>Bulk onboarding</span></a>@endif
        @if(auth()->user()->canAccessModule('properties'))<a href="{{ route('clients.index') }}" class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}"><i class="bi bi-person-workspace"></i><span>Clients</span></a>@endif

        @if(auth()->user()->canAccessModule('units'))<a href="{{ route('units.index') }}"
           class="menu-item {{ request()->routeIs('units.*') ? 'active' : '' }}">
            <i class="bi bi-door-open-fill"></i>
            <span>Units</span>
        </a>@endif

        @if(auth()->user()->canAccessModule('tenants'))<a href="{{ route('tenants.index') }}"
           class="menu-item {{ request()->routeIs('tenants.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span>Tenants</span>
        </a>@endif

        @if(auth()->user()->canAccessModule('leases'))<a href="{{ route('leases.index') }}"
           class="menu-item {{ request()->routeIs('leases.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text-fill"></i>
            <span>Leases</span>
        </a>@endif

        @if(auth()->user()->canAccessModule('maintenance'))<a href="{{ route('maintenance.index') }}" class="menu-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}"><i class="bi bi-tools"></i><span>Maintenance</span></a>@endif

        <p class="menu-label">Finance</p>

        @if(auth()->user()->canAccessModule('payments'))<a href="{{ route('payments.index') }}"
           class="menu-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i>
            <span>Payments</span>
        </a>@endif

        @if(auth()->user()->canAccessModule('expenses'))<a href="{{ route('expenses.index') }}"
           class="menu-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
            <i class="bi bi-receipt-cutoff"></i>
            <span>Expenses</span>
        </a>@endif

        @if(auth()->user()->canAccessModule('reports'))<a href="{{ route('reports.index') }}"
           class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line-fill"></i>
            <span>Reports</span>
        </a>@endif

        <p class="menu-label">System</p>

        <a href="{{ route('settings.index') }}"
           class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            <span>Settings</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <span class="avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </span>

            <span class="sidebar-user-details">
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ auth()->user()->role }}</small>
            </span>
        </div>
    </div>
</aside>
