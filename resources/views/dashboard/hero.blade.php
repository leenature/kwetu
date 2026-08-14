<section class="hero-dashboard">

    <div class="hero-overlay"></div>

    <div class="hero-content">

        <div class="hero-left">

            <span class="hero-badge">
                <i class="bi bi-stars"></i>
                Premium Dashboard
            </span>

            <h1>
                Good day,
                {{ auth()->user()->name }}
                👋
            </h1>

            <p>
                Here's what's happening across your properties today.
                Monitor revenue, occupancy, payments and performance
                from one intelligent dashboard.
            </p>

            <div class="hero-actions">

                <a href="{{ route('properties.index') }}"
                   class="btn btn-light hero-btn">

                    <i class="bi bi-buildings"></i>

                    View Properties

                </a>

                <a href="{{ route('payments.index') }}"
                   class="btn btn-primary hero-btn">

                    <i class="bi bi-cash-stack"></i>

                    Payments

                </a>

            </div>

        </div>

        <div class="hero-right">

            <div class="hero-stat">

                <div class="hero-stat">

    <small>Total Properties</small>

    <h2>{{ number_format($properties) }}</h2>

    <span>
        <i class="bi bi-arrow-up-right"></i>
        Growing portfolio
    </span>

</div>
            </div>

            <div class="hero-stat">

                <div class="hero-stat">

    <small>Occupancy</small>

    <h2>{{ $units ? round(($occupiedUnits/$units)*100) : 0 }}%</h2>

    <span>
        <i class="bi bi-check-circle-fill"></i>
        Healthy occupancy
    </span>

</div>
            </div>

           <div class="hero-stat">

    <small>Collected</small>

    <h2>KSh {{ number_format($collectedThisMonth) }}</h2>

    <span>
        <i class="bi bi-graph-up-arrow"></i>
        Monthly revenue
    </span>

</div>
            </div>

        </div>

    </div>

</section>