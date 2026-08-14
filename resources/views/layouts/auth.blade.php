<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kwetu PMS')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="marketing-body">
    <main class="auth-shell">
        <a href="{{ route('home') }}" class="auth-brand">
            <span><i class="bi bi-buildings-fill"></i></span>
            KWETU
        </a>

        @yield('content')
    </main>
</body>
</html>