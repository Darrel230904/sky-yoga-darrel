<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky Yoga - Authentication</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')

    <style>
        input::-ms-reveal,
        input::-ms-clear {
            display: none !important;
        }
    </style>
</head>
<body class="font-poppins antialiased bg-[#051024]">
    
    <main>
        @yield('content')
    </main>

    <script>
        function togglePassword(inputId, openIconId, closedIconId) {
            const input = document.getElementById(inputId);
            const openIcon = document.getElementById(openIconId);
            const closedIcon = document.getElementById(closedIconId);

            if (input.type === 'password') {
                input.type = 'text';
                openIcon.classList.remove('hidden');
                closedIcon.classList.add('hidden');
            } else {
                input.type = 'password';
                openIcon.classList.add('hidden');
                closedIcon.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>