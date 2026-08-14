<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title','Kwetu PMS')
    </title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet">
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
    @yield('page-styles')

</head>


<body>


<div class="app-wrapper">


    {{-- Sidebar --}}
    @include('partials.sidebar')



    {{-- Main Area --}}
    <main class="main-content">


        {{-- Navbar --}}
        @include('partials.navbar')



        <section class="page-content">

            @yield('content')

        </section>

        @include('partials.footer')


    </main>


</div>


@yield('page-scripts')
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
