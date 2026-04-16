<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky Yoga</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-[#0A1628] text-white font-poppins antialiased overflow-x-hidden">

    <nav class="max-w-[1400px] mx-auto px-8 py-8 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-cyan-400 to-blue-500"></div>
            <span class="text-2xl font-bold text-white tracking-wide">SKY YOGA</span>
        </a>
        
        <div class="hidden md:flex items-center gap-10 text-[15px] font-medium text-white">
            <a href="/" class="hover:text-[#FACC15] transition-colors">Home</a>
            <a href="#classes" class="hover:text-[#FACC15] transition-colors">Classes</a>
            <a href="#pricing" class="hover:text-[#FACC15] transition-colors">Pricing</a>
            
            @guest
                <a href="{{ route('login') }}" class="border-2 border-white px-8 py-2 rounded-lg hover:border-[#FACC15] hover:text-[#FACC15] transition-all">
                    LOGIN
                </a>
            @else
                <a href="{{ route('member.booking.history') }}" class="hover:text-[#FACC15] transition-colors">My Bookings</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="border-2 border-white px-8 py-2 rounded-lg hover:border-[#FACC15] hover:text-[#FACC15] transition-all">Logout</button>
                </form>
            @endguest
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>