<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky Yoga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-navy: #0A192F; /* Warna background utama */
            --bg-card: #112240; /* Warna card */
            --text-gold: #FACC15; /* Warna teks kuning/emas */
            --btn-gold: #EAB308; /* Warna tombol kuning */
        }
        body {
            background-color: var(--bg-navy);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .text-gold { color: var(--text-gold) !important; }
        .bg-card { background-color: var(--bg-card); border-radius: 15px; border: 1px solid #233554; }
        .btn-gold { background-color: var(--btn-gold); color: #0A192F; font-weight: bold; border-radius: 50px; }
        .btn-gold:hover { background-color: #ca9a04; color: #0A192F; }
        .navbar-nav .nav-link { color: white; margin-left: 15px; font-weight: 500; }
        .navbar-nav .nav-link:hover { color: var(--text-gold); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent pt-4 pb-4">
        <div class="container">
            <a class="navbar-brand text-gold fw-bold fs-3" href="/">
                SKY YOGA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Classes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link fw-bold text-white ms-3" href="{{ route('login') }}">LOGIN</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="#">My Bookings</a></li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-light rounded-pill btn-sm ms-3">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>