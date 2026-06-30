{{-- resources/views/components/sidebar.blade.php --}}
@php
    $menus = [
        'admin' => [
            ['id' => 'dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Tableau de bord', 'route' => 'dashboard.index'],
            ['group' => 'Établissement', 'items' => [
                ['id' => 'annees-academiques', 'icon' => 'fa-calendar-days', 'label' => 'Années académiques', 'route' => 'annees-academiques.index'],
                ['id' => 'departements', 'icon' => 'fa-building-columns', 'label' => 'Départements', 'route' => 'departements.index'],
                ['id' => 'specialites', 'icon' => 'fa-layer-group', 'label' => 'Spécialités', 'route' => 'specialites.index'],
                ['id' => 'niveaux', 'icon' => 'fa-stairs', 'label' => 'Niveaux', 'route' => 'niveaux.index'],
                ['id' => 'semestres', 'icon' => 'fa-clock', 'label' => 'Semestres', 'route' => 'semestres.index'],
                ['id' => 'ues', 'icon' => 'fa-cubes', 'label' => 'Unités d\'enseignement', 'route' => 'ues.index'],
                ['id' => 'matieres', 'icon' => 'fa-book', 'label' => 'Matières', 'route' => 'matieres.index'],
            ]],
            ['group' => 'Personnes', 'items' => [
                ['id' => 'personnels', 'icon' => 'fa-user-tie', 'label' => 'Personnel', 'route' => 'personnels.index'],
                ['id' => 'etudiants', 'icon' => 'fa-user-graduate', 'label' => 'Étudiants', 'route' => 'etudiants.index'],
                ['id' => 'inscriptions', 'icon' => 'fa-file-signature', 'label' => 'Inscriptions', 'route' => 'inscriptions.index'],
            ]],
            ['group' => 'Académique', 'items' => [
                ['id' => 'notes', 'icon' => 'fa-pen-to-square', 'label' => 'Notes', 'route' => 'notes.index'],
                ['id' => 'releves', 'icon' => 'fa-file-lines', 'label' => 'Relevés de notes', 'route' => 'releves.index'],
                ['id' => 'cartes', 'icon' => 'fa-id-card', 'label' => 'Cartes étudiants', 'route' => 'cartes.index'],
                ['id' => 'certificats', 'icon' => 'fa-file-shield', 'label' => 'Certificats', 'route' => 'certificats.index'],
                ['id' => 'listes', 'icon' => 'fa-list-check', 'label' => 'Listes administratives', 'route' => 'listes.index'],
            ]],
            ['group' => 'Décisionnel', 'items' => [
                ['id' => 'statistiques', 'icon' => 'fa-chart-pie', 'label' => 'Statistiques', 'route' => 'statistiques.index'],
            ]],
            ['group' => 'Administration', 'items' => [
                ['id' => 'users', 'icon' => 'fa-users-gear', 'label' => 'Utilisateurs & rôles', 'route' => 'users.index'],
                ['id' => 'settings', 'icon' => 'fa-sliders', 'label' => 'Paramètres', 'route' => 'settings.index'],
            ]],
        ],
        'employe' => [
            ['id' => 'dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Tableau de bord', 'route' => 'dashboard.index'],
            ['group' => 'Établissement', 'items' => [
                ['id' => 'departements', 'icon' => 'fa-building-columns', 'label' => 'Départements', 'route' => 'departements.index'],
                ['id' => 'specialites', 'icon' => 'fa-layer-group', 'label' => 'Spécialités', 'route' => 'specialites.index'],
                ['id' => 'niveaux', 'icon' => 'fa-stairs', 'label' => 'Niveaux', 'route' => 'niveaux.index'],
            ]],
            ['group' => 'Académique', 'items' => [
                ['id' => 'notes', 'icon' => 'fa-pen-to-square', 'label' => 'Saisie des notes', 'route' => 'notes.index'],
                ['id' => 'releves', 'icon' => 'fa-file-lines', 'label' => 'Relevés', 'route' => 'releves.index'],
                ['id' => 'cartes', 'icon' => 'fa-id-card', 'label' => 'Cartes étudiants', 'route' => 'cartes.index'],
            ]],
            ['group' => 'Décisionnel', 'items' => [
                ['id' => 'statistiques', 'icon' => 'fa-chart-pie', 'label' => 'Statistiques', 'route' => 'statistiques.index'],
            ]],
        ],
    ];

    $role = auth()->user()->roles->first()->name ?? 'employe';
    $roleKey = $role === 'admin' ? 'admin' : 'employe';
    $userMenus = $menus[$roleKey] ?? $menus['employe'];
    $currentRoute = request()->route()->getName() ?? 'dashboard.index';
@endphp

<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-72 grad-card text-brand-100 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col shadow-2xl">
    {{-- Logo --}}
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

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto scrollbar-thin p-3 space-y-1 text-sm" id="navMenu">
        @foreach($userMenus as $menu)
            @if(isset($menu['group']))
                <details class="mb-1" open>
                    <summary class="px-3 py-2 text-[11px] uppercase tracking-wider text-brand-200/80 font-semibold flex items-center justify-between cursor-pointer hover:text-white transition">
                        <span>{{ $menu['group'] }}</span>
                        <i class="fa-solid fa-chevron-right chev text-[10px] transition-transform"></i>
                    </summary>
                    <div class="space-y-0.5 mt-1">
                        @foreach($menu['items'] as $item)
                            <a href="{{ route($item['route']) }}" 
                               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-100 hover:bg-white/10 hover:text-white transition
                                      {{ $currentRoute === $item['route'] ? 'active' : '' }}">
                                <i class="fa-solid {{ $item['icon'] }} w-5 text-center"></i>
                                <span class="text-sm">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </details>
            @else
                <a href="{{ route($menu['route']) }}" 
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-100 hover:bg-white/10 hover:text-white transition
                          {{ $currentRoute === $menu['route'] ? 'active' : '' }}">
                    <i class="fa-solid {{ $menu['icon'] }} w-5 text-center"></i>
                    <span class="text-sm">{{ $menu['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    {{-- User Info --}}
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-white text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="text-[11px] text-brand-200 truncate capitalize">{{ $role }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-white/70 hover:text-white transition" title="Déconnexion">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Backdrop for mobile --}}
<div id="sidebarBackdrop" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/40 z-30 lg:hidden"></div>