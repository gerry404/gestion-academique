{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EduManager — Connexion</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .grad-blue {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 60%, #60a5fa 100%);
        }
        .grad-card {
            background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
        }
        .animate-pop {
            animation: pop 0.25s ease-out;
        }
        @keyframes pop {
            0% { opacity: 0; transform: scale(0.92); }
            100% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

<section class="min-h-screen grad-blue flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background decorations -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-brand-400/30 rounded-full blur-3xl"></div>

    <div class="relative w-full max-w-5xl grid md:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden animate-pop">
        <!-- Left panel -->
        <div class="hidden md:flex flex-col justify-between p-10 grad-card text-white relative">
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">EduManager</h1>
                        <p class="text-xs text-brand-100">Gestion Académique Intelligente</p>
                    </div>
                </div>
            </div>
            <div class="space-y-5">
                <h2 class="text-3xl font-bold leading-tight">Pilotez toute votre vie académique en un seul endroit.</h2>
                <p class="text-brand-100 text-sm">Inscriptions, notes, relevés, cartes étudiants, statistiques — automatisez et gagnez du temps.</p>
                <div class="grid grid-cols-3 gap-3 text-center pt-4">
                    <div class="bg-white/10 rounded-xl p-3">
                        <div class="text-2xl font-bold">2.5k</div>
                        <div class="text-xs">Étudiants</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3">
                        <div class="text-2xl font-bold">87%</div>
                        <div class="text-xs">Réussite</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3">
                        <div class="text-2xl font-bold">42</div>
                        <div class="text-xs">Filières</div>
                    </div>
                </div>
            </div>
            <p class="text-xs text-brand-100/70">&copy; 2025 EduManager — Tous droits réservés</p>
        </div>

        <!-- Login form -->
        <div class="p-8 sm:p-12 flex flex-col justify-center">
            <div class="mb-8">
                <div class="md:hidden flex items-center gap-2 mb-6">
                    <i class="fa-solid fa-graduation-cap text-brand-600 text-2xl"></i>
                    <span class="text-xl font-bold text-brand-700">EduManager</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Connexion sécurisée</h2>
                <p class="text-sm text-slate-500 mt-1">Accédez à votre espace personnel</p>
            </div>

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Identifiant</label>
                    <div class="relative mt-1">
                        <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full pl-10 pr-3 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('email') border-red-500 @enderror"
                            placeholder="admin@edu.cm"
                        />
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Mot de passe</label>
                    <div class="relative mt-1">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        />
                        <button type="button" onclick="togglePwd(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-600">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" name="remember" class="accent-brand-600 rounded w-4 h-4">
                        Se souvenir
                    </label>
                    <a href="#" class="text-brand-600 hover:underline font-medium">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="w-full grad-blue text-white py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:opacity-95 transition flex items-center justify-center gap-2">
                    <span>Connexion</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="mt-6 p-3 bg-brand-50 border border-brand-100 rounded-xl text-xs text-brand-800">
                <i class="fa-solid fa-circle-info mr-1"></i>
                <b>Démo :</b> admin@edu.cm / admin123
            </div>
        </div>
    </div>
</section>

<script>
function togglePwd(btn) {
    const input = btn.previousElementSibling;
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.querySelector('i').className = input.type === 'password' ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
}
</script>

</body>
</html>