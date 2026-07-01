
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo $__env->yieldContent('title', 'EduManager — Gestion Académique'); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

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

    <?php if(auth()->guard()->check()): ?>
        <div class="min-h-screen flex">
            <?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <main class="flex-1 flex flex-col min-w-0">
                <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="flex-1 p-4 sm:p-6 overflow-y-auto animate-fade-in">
                    <?php if(session('success')): ?>
                        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                            <i class="fa-solid fa-circle-check mr-2"></i> <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                            <i class="fa-solid fa-circle-exclamation mr-2"></i> <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </main>
        </div>
    <?php else: ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebarBackdrop').classList.toggle('hidden');
        }
    </script>
    


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

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\projet_atelier_tp\gestion-academique\gestion-academique\resources\views/layouts/app.blade.php ENDPATH**/ ?>