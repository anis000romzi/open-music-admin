<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>@yield('title') - MFT Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/18ba30db93.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    {{-- Datatables Resources --}}
    <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script defer src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
</head>

<body>
    <div class="dashboard">
        <div class="dashboard-nav">
            <header>
                <a href="#" class="menu-toggle"><i class="fas fa-bars"></i></a><a href="{{ route('home') }}"
                    class="brand-logo"><img src="{{ asset('music-removebg-preview.png') }}"
                        class="img-fluid rounded-start" style="width: 40px" alt="My Free Tunes logo">
                    <span>Admin</span></a>
            </header>
            <nav class="dashboard-nav-list">
                <a href="{{ route('home') }}" class="dashboard-nav-item @yield('nav-home')"><i class="fas fa-home"></i>
                    Home </a>
                <a href="{{ route('users') }}" class="dashboard-nav-item @yield('nav-users')"><i
                        class="fa-solid fa-user"></i> Users </a>
                <a href="{{ route('songs') }}" class="dashboard-nav-item @yield('nav-songs')"><i
                        class="fa-solid fa-music"></i> Songs</a>
                <a href="{{ route('albums') }}" class="dashboard-nav-item @yield('nav-albums')"><i
                        class="fa-solid fa-compact-disc"></i> Albums</a>
                <a href="{{ route('genres') }}" class="dashboard-nav-item @yield('nav-genres')"><i
                        class="fa-solid fa-icons"></i> Genres</a>
                <a href="{{ route('reports') }}" class="dashboard-nav-item @yield('nav-reports')"><i
                        class="fa-solid fa-flag"></i> Reports</a>
                <a href="#" class="dashboard-nav-item"><i class="fa-solid fa-at"></i>
                    {{ Auth::user()->username }}</a>
                <div class="nav-item-divider"></div>
                <button style="background-color: transparent; color: white; border: none;" type="button"
                    onclick="location.href = '{{ route('logout') }}';" class="dashboard-nav-item"><i
                        class="fas fa-sign-out-alt"></i> Logout
                </button>
            </nav>
        </div>
        <div class="dashboard-app">
            <header class="dashboard-toolbar">
                <a href="#" class="menu-toggle"><i class="fas fa-bars"></i></a>
            </header>
            <div class="dashboard-content">
                <div class="container">@yield('content')</div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

<script>
    const mobileScreen = window.matchMedia("(max-width: 990px )");
    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this)
                .closest(".dashboard-nav-dropdown")
                .toggleClass("show")
                .find(".dashboard-nav-dropdown")
                .removeClass("show");
            $(this).parent().siblings().removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (mobileScreen.matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });
</script>

</html>
