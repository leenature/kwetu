<header class="navbar">


    <div>

        <button class="mobile-menu">
            ☰
        </button>


        <h3>
            @yield('title','Dashboard')
        </h3>

    </div>



    <div class="navbar-actions">


        <button class="theme-toggle">
            🌙
        </button>



        <div class="notification">

            🔔

        </div>



        <div class="profile">

            <strong>
                {{ auth()->user()->name ?? 'Guest' }}
            </strong>

        </div>


    </div>


</header>