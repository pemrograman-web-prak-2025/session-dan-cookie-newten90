<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Event Calendar')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <style>
        /* Dark mode styles - Comprehensive */
        .dark {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        
        /* Background colors */
        .dark .bg-white {
            background-color: #1e293b !important;
        }
        .dark .bg-gray-50 {
            background-color: #0f172a !important;
        }
        .dark .bg-gray-100 {
            background-color: #1e293b !important;
        }
        .dark .bg-gray-400 {
            background-color: #475569 !important;
        }
        
        /* Text colors */
        .dark .text-gray-700 {
            color: #e2e8f0 !important;
        }
        .dark .text-gray-600 {
            color: #cbd5e0 !important;
        }
        .dark .text-gray-900 {
            color: #f1f5f9 !important;
        }
        .dark h1, .dark h2, .dark h3, .dark label, .dark span {
            color: #e2e8f0 !important;
        }
        
        /* Borders */
        .dark .border, .dark input, .dark textarea, .dark select {
            border-color: #475569 !important;
        }
        
        /* Inputs */
        .dark input, .dark textarea, .dark select {
            background-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        .dark input:focus, .dark textarea:focus, .dark select:focus {
            border-color: #3b82f6 !important;
        }
        
        /* Shadows */
        .dark .shadow, .dark .shadow-sm {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.5) !important;
        }
        
        /* Buttons - keep colors but adjust hover */
        .dark .bg-blue-600:hover {
            background-color: #2563eb !important;
        }
        .dark .bg-red-600:hover {
            background-color: #dc2626 !important;
        }
        .dark .bg-green-600:hover {
            background-color: #16a34a !important;
        }
        .dark .bg-gray-400:hover {
            background-color: #64748b !important;
        }
        
        /* FullCalendar Dark Mode */
        .dark .fc {
            background-color: #1e293b !important;
        }
        .dark .fc-toolbar {
            color: #e2e8f0 !important;
        }
        .dark .fc-button {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
        }
        .dark .fc-button:hover {
            background-color: #2563eb !important;
        }
        .dark .fc-daygrid-day {
            background-color: #1e293b !important;
        }
        .dark .fc-daygrid-day:hover {
            background-color: #334155 !important;
        }
        .dark .fc-col-header-cell {
            background-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        .dark .fc-daygrid-day-number {
            color: #e2e8f0 !important;
        }
        .dark .fc-day-today {
            background-color: #334155 !important;
        }
        
        /* Alert boxes */
        .dark .bg-green-100 {
            background-color: #166534 !important;
            border-color: #16a34a !important;
        }
        .dark .text-green-700 {
            color: #86efac !important;
        }
        .dark .bg-red-100 {
            background-color: #7f1d1d !important;
            border-color: #dc2626 !important;
        }
        .dark .text-red-700 {
            color: #fca5a5 !important;
        }
        .dark .bg-yellow-100 {
            background-color: #713f12 !important;
            color: #fde047 !important;
        }
        .dark .text-yellow-800 {
            color: #fde047 !important;
        }
        
        /* Links */
        .dark a {
            color: #60a5fa !important;
        }
        .dark a:hover {
            color: #93c5fd !important;
        }
        
        /* Navbar */
        .dark nav {
            background-color: #1e293b !important;
            border-bottom: 1px solid #475569;
        }
        
        /* Title keep blue */
        .dark .text-blue-600 {
            color: #3b82f6 !important;
        }
    </style>
</head>
<body class="bg-gray-50 transition-colors duration-200" id="app-body">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">📅 Event Calendar</h1>
                </div>
                @auth
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle Button -->
                    <button onclick="toggleDarkMode()" class="text-gray-700 hover:text-gray-900 flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg id="sun-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg id="moon-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <span id="mode-text" class="text-sm font-medium">Dark</span>
                    </button>
                    
                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Logout</button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script>
        // Fungsi untuk toggle dark mode
        function toggleDarkMode() {
            const body = document.getElementById('app-body');
            const html = document.documentElement;
            const isDark = body.classList.contains('dark');
            const newMode = !isDark;
            
            // Toggle class dark pada body dan html
            if (newMode) {
                body.classList.add('dark');
                html.classList.add('dark');
                document.getElementById('sun-icon').classList.remove('hidden');
                document.getElementById('moon-icon').classList.add('hidden');
                document.getElementById('mode-text').textContent = 'Light';
            } else {
                body.classList.remove('dark');
                html.classList.remove('dark');
                document.getElementById('sun-icon').classList.add('hidden');
                document.getElementById('moon-icon').classList.remove('hidden');
                document.getElementById('mode-text').textContent = 'Dark';
            }
            
            // Simpan ke cookie via AJAX
            fetch('/toggle-dark-mode', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    dark_mode: newMode ? 'true' : 'false'
                })
            });
        }

        // Check cookie saat page load
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Apply dark mode dari cookie saat page load (SEBELUM page muncul)
        (function() {
            const darkMode = getCookie('dark_mode');
            const body = document.getElementById('app-body');
            const html = document.documentElement;
            
            if (darkMode === 'true') {
                body.classList.add('dark');
                html.classList.add('dark');
            }
        })();

        // Update icon dan text setelah DOM ready
        window.addEventListener('DOMContentLoaded', function() {
            const darkMode = getCookie('dark_mode');
            
            if (darkMode === 'true') {
                document.getElementById('sun-icon').classList.remove('hidden');
                document.getElementById('moon-icon').classList.add('hidden');
                document.getElementById('mode-text').textContent = 'Light';
            }
        });
    </script>
</body>
</html>