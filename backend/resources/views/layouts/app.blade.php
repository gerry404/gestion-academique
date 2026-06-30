{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'EduManager — Gestion Académique')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans">

    @auth
        <div id="app" class="min-h-screen flex">
            {{-- Sidebar --}}
            @include('components.sidebar')

            {{-- Main Content --}}
            <main class="flex-1 flex flex-col min-w-0">
                {{-- Header --}}
                @include('components.header')

                {{-- Page Content --}}
                <div class="flex-1 p-4 sm:p-6 overflow-y-auto animate-fade-in">
                    @yield('content')
                </div>

                {{-- Footer --}}
                @include('components.footer')
            </main>
        </div>
    @else
        @yield('content')
    @endauth

    {{-- Toast Container --}}
    <div id="toasts" class="fixed top-20 right-4 z-[100] space-y-2 w-80 max-w-[90vw]"></div>

    {{-- Modal Root --}}
    <div id="modalRoot"></div>

    @stack('scripts')
    
    <script>
        // Fonctions globales
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
                if (backdrop) backdrop.classList.toggle('hidden');
            }
        }

        function closeModal() {
            document.getElementById('modalRoot').innerHTML = '';
        }

        function openModal(html, size = 'max-w-lg') {
            document.getElementById('modalRoot').innerHTML = `
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm animate-fade-in" onclick="if(event.target===this)closeModal()">
                    <div class="bg-white rounded-2xl w-full ${size} max-h-[90vh] overflow-y-auto scrollbar-thin shadow-2xl animate-pop">${html}</div>
                </div>
            `;
        }

        function toast(message, type = 'info') {
            const colors = {
                success: 'bg-emerald-600',
                error: 'bg-red-600',
                warning: 'bg-amber-500',
                info: 'bg-brand-600'
            };
            const icons = {
                success: 'fa-circle-check',
                error: 'fa-circle-xmark',
                warning: 'fa-triangle-exclamation',
                info: 'fa-circle-info'
            };
            
            const container = document.getElementById('toasts');
            const el = document.createElement('div');
            el.className = `toast ${colors[type]} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 text-sm`;
            el.innerHTML = `
                <i class="fa-solid ${icons[type]}"></i>
                <span class="flex-1">${message}</span>
                <button onclick="this.parentElement.remove()" class="opacity-70 hover:opacity-100">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            `;
            container.appendChild(el);
            setTimeout(() => {
                el.style.transition = 'all .3s';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-10px)';
                setTimeout(() => el.remove(), 300);
            }, 4000);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</body>
</html>