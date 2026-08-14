<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwetu PMS — Property management made simple</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="marketing-body">
    <div class="marketing-page">
        <div class="marketing-orbs" aria-hidden="true"><span></span><span></span><span></span><i></i><i></i><i></i><i></i><i></i></div>
        <nav class="marketing-nav">
            <a href="{{ route('home') }}" class="marketing-brand">
                <span><i class="bi bi-buildings-fill"></i></span>
                KWETU
            </a>

            <div class="marketing-nav-links">
                <a href="#pricing">Pricing</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn-marketing-primary">
                        Open Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    <a href="{{ route('register') }}" class="btn-marketing-primary">
                        Start free trial
                    </a>
                @endauth
            </div>
        </nav>

        <section class="hero-section marketing-container">
            <span class="hero-badge">
                <i class="bi bi-stars"></i>
                Built for modern property teams
            </span>

            <h1>{{ $content['hero_title'] }}</h1>

            <p>
                {{ $content['hero_text'] }}
            </p>

            <div class="hero-actions">
                <a href="{{ route('register', ['plan' => 'starter']) }}"
                   class="btn-marketing-primary">
                    Start 14-day free trial
                </a>

                <a href="{{ route('residences.index') }}" class="btn-marketing-secondary">
                    Find a residence
                </a>
            </div>
            <div class="hero-trust"><span><i class="bi bi-shield-check"></i> Verified property locations</span><span><i class="bi bi-people"></i> Built for growing teams</span><span><i class="bi bi-graph-up"></i> Live portfolio insight</span></div>
        </section>

        <section class="gateway-strip" aria-label="Supported payment gateway vision">
            @if($partners->isNotEmpty())
                <p>Trusted service partners</p>
                <div class="gateway-track mb-3"><div class="gateway-items">
                    @foreach($partners->concat($partners) as $partner)
                        <a href="{{ $partner->website ?: '#' }}" target="_blank" rel="noopener"><i class="bi {{ $partner->icon }}"></i> {{ $partner->name }}</a>
                    @endforeach
                </div></div>
            @endif
            <p>Designed to work with the payments your tenants already trust</p>
            <div class="gateway-track"><div class="gateway-items"><span><i class="bi bi-phone-fill"></i> M-PESA</span><span>Equity Bank</span><span>Co-operative Bank</span><span>Family Bank</span><span>I&amp;M Bank</span><span>KCB</span><span>NCBA</span><span><i class="bi bi-phone-fill"></i> M-PESA</span><span>Equity Bank</span><span>Co-operative Bank</span><span>Family Bank</span><span>I&amp;M Bank</span><span>KCB</span><span>NCBA</span></div></div>
        </section>

        <section class="marketing-section marketing-container">
            <div class="marketing-heading">
                <h2>Everything your portfolio needs</h2>
                <p>Simple workflows for every part of property management.</p>
            </div>

            <div class="feature-grid">
                <article class="marketing-card">
                    <i class="bi bi-buildings-fill"></i>
                    <h3>Portfolio control</h3>
                    <p>Manage properties, units, availability, and occupancy from one workspace.</p>
                </article>

                <article class="marketing-card">
                    <i class="bi bi-people-fill"></i>
                    <h3>Tenant lifecycle</h3>
                    <p>Register tenants, manage leases, and keep occupancy records accurate.</p>
                </article>

                <article class="marketing-card">
                    <i class="bi bi-graph-up-arrow"></i>
                    <h3>Financial clarity</h3>
                    <p>Monitor collections, expenses, outstanding balances, and revenue trends.</p>
                </article>
            </div>
        </section>

        <section class="marketing-section marketing-container">
            <div class="marketing-heading"><h2>A clearer day for every property team</h2><p>From a morning collection check to a month-end report, Kwetu keeps the work moving.</p></div>
            <div class="feature-grid">
                <article class="marketing-card"><i class="bi bi-lightning-charge-fill"></i><h3>Start with what matters</h3><p>See occupancy, collections and key actions as soon as you open your workspace.</p></article>
                <article class="marketing-card"><i class="bi bi-receipt"></i><h3>Every shilling accounted for</h3><p>Capture payment receipts and operating expenses against the property they belong to.</p></article>
                <article class="marketing-card"><i class="bi bi-shield-check"></i><h3>Teams with clear access</h3><p>Give owners, managers, accountants and caretakers the tools they need.</p></article>
            </div>
        </section>

        <section id="pricing" class="marketing-section marketing-container">
            <div class="marketing-heading">
                <h2>Simple pricing for every stage</h2>
                <p>Every plan starts with a 14-day free trial. No payment details required.</p>
            </div>

            <div class="pricing-grid">
                <article class="pricing-card">
                    <h3>Starter</h3>
                    <div class="price">KSh 0 <small>/ month</small></div>
                    <ul>
                        <li>Up to 2 properties</li>
                        <li>Tenant and lease tracking</li>
                        <li>Payment records</li>
                    </ul>
                    <a href="{{ route('register', ['plan' => 'starter']) }}"
                       class="btn-marketing-secondary">
                        Start free trial
                    </a>
                </article>

                <article class="pricing-card featured">
                    <h3>Growth</h3>
                    <div class="price">KSh 2,500 <small>/ month</small></div>
                    <ul>
                        <li>Up to 20 properties</li>
                        <li>Expense tracking</li>
                        <li>Reports and analytics</li>
                    </ul>
                    <a href="{{ route('register', ['plan' => 'growth']) }}"
                       class="btn-marketing-primary">
                        Start free trial
                    </a>
                </article>

                <article class="pricing-card">
                    <h3>Pro</h3>
                    <div class="price">KSh 5,000 <small>/ month</small></div>
                    <ul>
                        <li>Unlimited properties</li>
                        <li>Team roles and access</li>
                        <li>Priority support</li>
                    </ul>
                    <a href="{{ route('register', ['plan' => 'pro']) }}"
                       class="btn-marketing-secondary">
                        Start free trial
                    </a>
                </article>
            </div>
        </section>
        <section class="marketing-section marketing-container">
            <div class="marketing-heading"><h2>Frequently asked questions</h2><p>Everything you need to know before setting up your first workspace.</p></div>
            <div class="accordion" id="faq"><div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faqOne">Can I manage more than one property?</button></h3><div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#faq"><div class="accordion-body">Yes. Add properties, their units, tenants and leases inside one workspace and track each portfolio separately.</div></div></div><div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faqTwo">Which roles can use Kwetu?</button></h3><div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Owners can manage their teams, while managers, accountants and caretakers receive the modules relevant to their daily work.</div></div></div><div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faqThree">Can I track M-Pesa payments?</button></h3><div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Yes. Record M-Pesa alongside cash, bank transfer, card and other collection methods with a reference number.</div></div></div></div>
        </section>
        @include('partials.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
