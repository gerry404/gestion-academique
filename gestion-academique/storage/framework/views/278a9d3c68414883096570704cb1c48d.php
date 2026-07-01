


<?php $__env->startSection('title', 'Semestres - EduManager'); ?>

<?php
    $pageTitle = 'Semestres';
    $pageSub = 'Gestion des semestres par année et niveau';
?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="flex flex-wrap gap-2 flex-1">
        <div class="relative max-w-sm flex-1 min-w-[200px]">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <form method="GET" action="<?php echo e(route('semestres.index')); ?>" class="inline">
                <input type="text" name="search" placeholder="Rechercher un semestre..."
                       value="<?php echo e(request('search')); ?>"
                       class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="<?php echo e(route('semestres.index')); ?>" class="inline">
                <select name="annee_academique_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Toutes les années</option>
                    <?php $__currentLoopData = $anneesAcademiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($annee->id); ?>" <?php echo e(request('annee_academique_id') == $annee->id ? 'selected' : ''); ?>>
                            <?php echo e($annee->libelle); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="<?php echo e(route('semestres.index')); ?>" class="inline">
                <select name="niveau_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Tous les niveaux</option>
                    <?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($niveau->id); ?>" <?php echo e(request('niveau_id') == $niveau->id ? 'selected' : ''); ?>>
                            <?php echo e($niveau->display_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        </div>
    </div>
    <div class="flex gap-2 flex-wrap">
       
        <a href="<?php echo e(route('semestres.create')); ?>"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouveau semestre
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
                    <th class="px-4 py-3 text-left font-semibold">#</th>
                    <th class="px-4 py-3 text-left font-semibold">Libellé</th>
                    <th class="px-4 py-3 text-left font-semibold">Niveau</th>
                    <th class="px-4 py-3 text-left font-semibold">Année académique</th>
                    <th class="px-4 py-3 text-left font-semibold">Matières</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $semestres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semestre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 text-slate-500">#<?php echo e($semestre->id); ?></td>
                    <td class="px-4 py-3 font-bold text-brand-700"><?php echo e($semestre->libelle); ?></td>
                    <td class="px-4 py-3">
                        <?php if($semestre->niveau): ?>
                            <?php echo e($semestre->niveau->libelle); ?>

                            <span class="text-xs text-slate-400 block">
                                <?php echo e($semestre->niveau->specialite->libelle ?? ''); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-slate-400">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3"><?php echo e($semestre->anneeAcademique->libelle ?? '-'); ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            <?php echo e($semestre->matieres->count()); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="<?php echo e(route('semestres.show', $semestre)); ?>"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition"
                           title="Voir">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="<?php echo e(route('semestres.edit', $semestre)); ?>"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition"
                           title="Modifier">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="<?php echo e(route('semestres.destroy', $semestre)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression de ce semestre ?')"
                                    class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition"
                                    title="Supprimer">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                        <i class="fa-solid fa-clock text-4xl text-slate-300 mb-2 block"></i>
                        Aucun semestre trouvé
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <?php echo e($semestres->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projet_atelier_tp\gestion-academique\gestion-academique\resources\views/etablissement/semestres/index.blade.php ENDPATH**/ ?>