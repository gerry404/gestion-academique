{{-- resources/views/components/sidebar.blade.php --}}
@php
    $menus = [
        ['id' => 'dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Tableau de bord', 'route' => 'dashboard'],
        ['group' => 'Établissement', 'items' => [
            ['id' => 'annees-academiques', 'icon' => 'fa-calendar-days', 'label' => 'Années académiques', 'route' => 'annees-academiques.index'],
            ['id' => 'personnels', 'icon' => 'fa-user-tie', 'label' => 'Personnel', 'route' => 'personnels.index'], // ✅ Déplacé ici
            ['id' => 'departements', 'icon' => 'fa-building-columns', 'label' => 'Départements', 'route' => 'departements.index'],
            ['id' => 'specialites', 'icon' => 'fa-layer-group', 'label' => 'Spécialités', 'route' => 'specialites.index'],
            ['id' => 'niveaux', 'icon' => 'fa-stairs', 'label' => 'Niveaux', 'route' => 'niveaux.index'],
            ['id' => 'semestres', 'icon' => 'fa-clock', 'label' => 'Semestres', 'route' => 'semestres.index'],
            ['id' => 'ues', 'icon' => 'fa-cubes', 'label' => 'Unités d\'enseignement', 'route' => 'ues.index'],
            ['id' => 'matieres', 'icon' => 'fa-book', 'label' => 'Matières', 'route' => 'matieres.index'],
            ['id' => 'diplomes', 'icon' => 'fa-award', 'label' => 'Diplômes', 'route' => 'diplomes.index'],
        ]],
        ['group' => 'Personnes', 'items' => [
            ['id' => 'etudiants', 'icon' => 'fa-user-graduate', 'label' => 'Étudiants', 'route' => 'etudiants.index'],
        ]],
        ['group' => 'Administration', 'items' => [
            ['id' => 'users', 'icon' => 'fa-users-gear', 'label' => 'Utilisateurs', 'route' => 'users.index'],
            ['id' => 'settings', 'icon' => 'fa-sliders', 'label' => 'Paramètres', 'route' => 'settings.index'],
        ]],
    ];
    $currentRoute = request()->route()->getName() ?? 'dashboard';
@endphp

<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-72 grad-card text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col shadow-2xl">
    <!-- Logo -->
    <div class="p-5 border-b border-white/10 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg leading-tight">EduManager</h1>
                <p class="text-[11px] text-brand-200">v1.0 • Académique</p>
            </div>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden text-white">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto scrollbar-thin p-3 space-y-1 text-sm">
        @foreach($menus as $menu)
            @if(isset($menu['group']))
                <details class="mb-1" open>
                    <summary class="px-3 py-2 text-[11px] uppercase tracking-wider text-white/80 font-semibold flex items-center justify-between cursor-pointer hover:text-white transition">
                        <span>{{ $menu['group'] }}</span>
                        <i class="fa-solid fa-chevron-right chev text-[10px] transition-transform"></i>
                    </summary>
                    <div class="space-y-0.5 mt-1">
                        @foreach($menu['items'] as $item)
                            <a href="{{ route($item['route']) }}"
                               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition
                                      {{ $currentRoute === $item['route'] ? 'active' : '' }}">
                                <i class="fa-solid {{ $item['icon'] }} w-5 text-center"></i>
                                <span class="text-sm">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </details>
            @else
                <a href="{{ route($menu['route']) }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition
                          {{ $currentRoute === $menu['route'] ? 'active' : '' }}">
                    <i class="fa-solid {{ $menu['icon'] }} w-5 text-center"></i>
                    <span class="text-sm">{{ $menu['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-white text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="text-[11px] text-brand-200 truncate">Administrateur</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white/70 hover:text-white transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Backdrop for mobile -->
<div id="sidebarBackdrop" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/40 z-30 lg:hidden"></div>