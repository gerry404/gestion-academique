{{-- resources/views/components/header.blade.php --}}
@php
    $pageTitle = $pageTitle ?? 'Tableau de bord';
    $pageSub = $pageSub ?? 'Vue d\'ensemble de votre établissement';
@endphp

<header class="sticky top-0 z-20 glass border-b border-slate-200">
    <div class="flex items-center gap-3 px-4 sm:px-6 h-16">
        {{-- Mobile menu toggle --}}
        <button onclick="toggleSidebar()" class="lg:hidden text-slate-600 text-xl hover:text-brand-600 transition">
            <i class="fa-solid fa-bars"></i>
        </button>
        
        {{-- Page title --}}
        <div class="min-w-0">
            <h2 class="text-lg sm:text-xl font-bold text-slate-800 truncate">{{ $pageTitle }}</h2>
            <p class="text-xs text-slate-500 truncate hidden sm:block">{{ $pageSub }}</p>
        </div>
        
        <div class="flex-1"></div>
        
        {{-- Search bar --}}
        <div class="relative hidden md:block">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input 
                type="text" 
                placeholder="Rechercher..." 
                class="pl-9 pr-3 py-2 w-56 lg:w-72 bg-slate-100 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-brand-200 outline-none transition"
                id="globalSearch"
                onkeyup="if(event.key==='Enter' && this.value.length>2) window.location.href='{{ route('search') }}?q='+encodeURIComponent(this.value)"
            />
        </div>
        
        {{-- Notifications --}}
        <button onclick="openNotifications()" class="relative w-10 h-10 rounded-lg bg-slate-100 hover:bg-brand-50 flex items-center justify-center text-slate-600 transition">
            <i class="fa-solid fa-bell"></i>
            @if($unreadNotifications ?? 0 > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold">
                    {{ $unreadNotifications ?? 0 }}
                </span>
            @endif
        </button>
        
        {{-- Settings --}}
        <button onclick="window.location.href='{{ route('settings.index') }}'" class="w-10 h-10 rounded-lg bg-slate-100 hover:bg-brand-50 flex items-center justify-center text-slate-600 transition">
            <i class="fa-solid fa-gear"></i>
        </button>
        
        {{-- User profile --}}
        <button onclick="openProfile()" class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-lg hover:bg-slate-100 transition">
            <div class="w-8 h-8 rounded-full grad-blue text-white flex items-center justify-center text-sm font-semibold">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="hidden sm:block text-left">
                <div class="text-sm font-semibold text-slate-800 leading-tight">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="text-[11px] text-slate-500 capitalize">{{ $role ?? 'Administrateur' }}</div>
            </div>
        </button>
    </div>
</header>

@push('scripts')
<script>
function openNotifications() {
    fetch("{{ route('notifications') }}")
        .then(response => response.json())
        .then(data => {
            const html = `
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold">Notifications</h3>
                        <button onclick="closeModal()" class="w-9 h-9 rounded-lg hover:bg-slate-100">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <ul class="space-y-3 max-h-96 overflow-y-auto">
                        ${data.notifications.map(n => `
                            <li class="flex gap-3 p-3 hover:bg-slate-50 rounded-xl">
                                <div class="w-10 h-10 rounded-lg ${n.color} flex items-center justify-center shrink-0">
                                    <i class="fa-solid ${n.icon}"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm text-slate-700">${n.message}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">${n.time}</p>
                                </div>
                            </li>
                        `).join('')}
                    </ul>
                    <button onclick="markAllRead()" class="w-full mt-4 py-2.5 bg-brand-50 text-brand-700 rounded-xl text-sm font-semibold hover:bg-brand-100 transition">
                        Marquer tout comme lu
                    </button>
                </div>
            `;
            openModal(html, 'max-w-md');
        })
        .catch(() => toast('Erreur lors du chargement des notifications', 'error'));
}

function openProfile() {
    const html = `
        <div class="p-6 text-center">
            <div class="w-20 h-20 rounded-full grad-blue text-white mx-auto flex items-center justify-center text-3xl font-bold">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <h3 class="font-bold text-lg mt-3">{{ auth()->user()->name ?? 'Admin' }}</h3>
            <p class="text-sm text-slate-500 capitalize">{{ $role ?? 'Administrateur' }}</p>
            <p class="text-sm text-slate-500">{{ auth()->user()->email ?? '' }}</p>
            <div class="grid grid-cols-2 gap-2 mt-5">
                <button onclick="window.location.href='{{ route('profile.edit') }}'" class="p-3 bg-slate-100 rounded-xl text-sm hover:bg-slate-200 transition">
                    <i class="fa-solid fa-user-pen text-brand-600"></i>
                    <div class="mt-1">Mon profil</div>
                </button>
                <button onclick="document.getElementById('logout-form').submit()" class="p-3 bg-red-50 text-red-600 rounded-xl text-sm hover:bg-red-100 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <div class="mt-1">Déconnexion</div>
                </button>
            </div>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    `;
    openModal(html, 'max-w-sm');
}

function markAllRead() {
    fetch("{{ route('notifications.mark-all-read') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(() => {
        toast('Toutes les notifications ont été marquées comme lues', 'success');
        closeModal();
    })
    .catch(() => toast('Erreur', 'error'));
}
</script>
@endpush