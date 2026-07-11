<div class="bg-dark text-white vh-100" style="width:260px">

    <div class="p-3 border-bottom">
        <h3 class="mb-0">🏠 Kwetu</h3>
        <small>Smart Property Management</small>
    </div>

    <ul class="nav flex-column mt-3">

        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link text-white">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('organizations.index') }}" class="nav-link text-white">
                <i class="bi bi-diagram-3"></i>
                Organization
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('properties.index') }}" class="nav-link text-white">
                <i class="bi bi-buildings"></i>
                Properties
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('units.index') }}" class="nav-link text-white">
                <i class="bi bi-door-open"></i>
                Units
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('tenants.index') }}" class="nav-link text-white">
                <i class="bi bi-people"></i>
                Tenants
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('leases.index') }}" class="nav-link text-white">
                <i class="bi bi-file-earmark-text"></i>
                Leases
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('payments.index') }}" class="nav-link text-white">
                <i class="bi bi-cash-stack"></i>
                Payments
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('expenses.index') }}" class="nav-link text-white">
                <i class="bi bi-wallet2"></i>
                Expenses
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('reports.index') }}" class="nav-link text-white">
                <i class="bi bi-bar-chart"></i>
                Reports
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('settings.index') }}" class="nav-link text-white">
                <i class="bi bi-gear"></i>
                Settings
            </a>
        </li>

    </ul>

</div>