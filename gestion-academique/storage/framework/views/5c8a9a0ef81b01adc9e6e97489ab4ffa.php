


<?php $__env->startSection('title', 'Années académiques - EduManager'); ?>

<?php
    $pageTitle = 'Années académiques';
    $pageSub = 'Gérer les périodes officielles de formation';
?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="relative max-w-sm flex-1">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <form method="GET" action="<?php echo e(route('annees-academiques.index')); ?>" class="inline">
            <input type="text" name="search" placeholder="Rechercher une année..."
                   value="<?php echo e(request('search')); ?>"
                   class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
        </form>
    </div>
    <div class="flex gap-2 flex-wrap">
       
        <button onclick="toast('Export Excel lancé', 'info')"
                class="px-3 py-2.5 bg-gray border border-slate-200 rounded-xl text-sm hover:bg-white">
            <i class="fa-solid fa-file-excel text-green-600"></i> Excel
        </button>
        <a href="<?php echo e(route('annees-academiques.create')); ?>"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouvelle année
        </a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-500"></i>
        <span><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
        <span><?php echo e(session('error')); ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">ID</th>
                    <th class="px-4 py-3 text-left font-semibold">Libellé</th>
                    <th class="px-4 py-3 text-left font-semibold">Date début</th>
                    <th class="px-4 py-3 text-left font-semibold">Date fin</th>
                    <th class="px-4 py-3 text-left font-semibold">Note validation</th>
                    <th class="px-4 py-3 text-left font-semibold">Statut</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-medium text-slate-800">#<?php echo e($annee->id); ?></td>
                    <td class="px-4 py-3 font-bold text-brand-700"><?php echo e($annee->libelle); ?></td>
                    <td class="px-4 py-3"><?php echo e($annee->date_debut ? \Carbon\Carbon::parse($annee->date_debut)->format('d/m/Y') : '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($annee->date_fin ? \Carbon\Carbon::parse($annee->date_fin)->format('d/m/Y') : '-'); ?></td>
                    <td class="px-4 py-3"><?php echo e($annee->note_validation); ?>/20</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($annee->est_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'); ?>">
                            <?php echo e($annee->est_active ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="<?php echo e(route('annees-academiques.show', $annee)); ?>"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="<?php echo e(route('annees-academiques.edit', $annee)); ?>"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="<?php echo e(route('annees-academiques.toggle-status', $annee)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="w-8 h-8 rounded-lg <?php echo e($annee->est_active ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-green-100 text-green-600 hover:bg-green-200'); ?> inline-flex items-center justify-center ml-1 transition">
                                <i class="fa-solid <?php echo e($annee->est_active ? 'fa-pause' : 'fa-play'); ?> text-xs"></i>
                            </button>
                        </form>
                        <form action="<?php echo e(route('annees-academiques.destroy', $annee)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression de cette année académique ?')"
                                    class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-slate-500">
                        <i class="fa-solid fa-calendar-days text-4xl text-slate-300 mb-2 block"></i>
                        Aucune année académique trouvée
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <?php echo e($annees->links()); ?>

</div>

<?php $__env->startPush('scripts'); ?>
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

    const container = document.getElementById('toasts') || document.body;
    const el = document.createElement('div');
    el.className = `toast ${colors[type]} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 text-sm fixed top-20 right-4 z-[100]`;
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projet_atelier_tp\gestion-academique\gestion-academique\resources\views/etablissement/annees/index.blade.php ENDPATH**/ ?>