
<?php
    $pageTitle = $pageTitle ?? 'Tableau de bord';
    $pageSub = $pageSub ?? 'Vue d\'ensemble de votre établissement';
?>

<header class="sticky top-0 z-20 glass border-b border-slate-200">
    <div class="flex items-center gap-3 px-4 sm:px-6 h-16">
        <!-- Mobile menu toggle -->
        <button onclick="toggleSidebar()" class="lg:hidden text-slate-600 text-xl hover:text-brand-600 transition">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Page title -->
        <div class="min-w-0">
            <h2 class="text-lg sm:text-xl font-bold text-slate-800 truncate"><?php echo e($pageTitle); ?></h2>
            <p class="text-xs text-slate-500 truncate hidden sm:block"><?php echo e($pageSub); ?></p>
        </div>

        <div class="flex-1"></div>

        <!-- Search bar -->
        <div class="relative hidden md:block">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" placeholder="Rechercher..."
                   class="pl-9 pr-3 py-2 w-56 lg:w-72 bg-slate-100 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-brand-200 outline-none transition"/>
        </div>

        <!-- Notifications - Correction -->
        <button class="relative w-10 h-10 rounded-lg bg-slate-100 hover:bg-brand-50 flex items-center justify-center text-slate-600 transition">
            <i class="fa-solid fa-bell text-lg"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold">3</span>
        </button>

        <!-- Settings -->
        <button onclick="window.location.href='<?php echo e(route('settings.index')); ?>'"
                class="w-10 h-10 rounded-lg bg-slate-100 hover:bg-brand-50 flex items-center justify-center text-slate-600 transition">
            <i class="fa-solid fa-gear text-lg"></i>
        </button>

        <!-- Profile -->
        <div class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-lg hover:bg-slate-100 cursor-pointer transition">
            <div class="w-8 h-8 rounded-full grad-blue text-white flex items-center justify-center text-sm font-semibold">
                <?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?>

            </div>
            <div class="hidden sm:block text-left">
                <div class="text-sm font-semibold text-slate-800 leading-tight"><?php echo e(auth()->user()->name ?? 'Admin'); ?></div>
                <div class="text-[11px] text-slate-500">Administrateur</div>
            </div>
        </div>
    </div>
</header><?php /**PATH D:\projet_atelier_tp\gestion-academique\gestion-academique\resources\views/components/header.blade.php ENDPATH**/ ?>