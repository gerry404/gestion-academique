{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'EduManager — Gestion Académique')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .grad-blue {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 60%, #60a5fa 100%);
        }
        .grad-card {
            background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
        }
        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.85);
        }
        .sidebar-link {
            transition: all 0.2s ease;
            position: relative;
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(255,255,255,0.18), rgba(255,255,255,0.05));
            color: #fff;
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 3px;
            background: #fff;
            border-radius: 0 4px 4px 0;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .card-hover {
            transition: all 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px -10px rgba(37,99,235,0.35);
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

    @auth
        <div class="min-h-screen flex">
            @include('components.sidebar')
            <main class="flex-1 flex flex-col min-w-0">
                @include('components.header')
                <div class="flex-1 p-4 sm:p-6 overflow-y-auto animate-fade-in">
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                            <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
                        </div>
                    @endif
                    @yield('content')
                </div>
                @include('components.footer')
            </main>
        </div>
    @else
        @yield('content')
    @endauth

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebarBackdrop').classList.toggle('hidden');
        }
    </script>
    {{-- resources/views/layouts/app.blade.php --}}
{{-- Ajouter ceci avant la fermeture du body --}}

<!-- Toast container -->
<div id="toasts" class="fixed top-20 right-4 z-[100] space-y-2 w-80 max-w-[90vw]"></div>

<script>
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
</script>
</body>
</html>