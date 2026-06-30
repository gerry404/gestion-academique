@extends('layouts.app')

@section('title', 'Niveaux')
@section('page-title', 'Niveaux')
@section('page-subtitle', 'Cycle d\'études par département')

@section('content')
<div x-data="{ showCreate: false, showEdit: false, editItem: {} }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <form method="GET" action="{{ route('niveaux.index') }}" class="flex gap-3 flex-1 max-w-3xl flex-wrap">
            <select name="departement_id" onchange="this.form.submit()" class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
                <option value="">Tous les départements</option>
                @foreach($departements as $dep)
                    <option value="{{ $dep->id }}" {{ request('departement_id') == $dep->id ? 'selected' : '' }}>{{ $dep->libelle }}</option>
                @endforeach
            </select>
            <select name="annee_academique_id" onchange="this.form.submit()" class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
                <option value="">Toutes les années</option>
                @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>{{ $annee->libelle }}</option>
                @endforeach
            </select>
        </form>
        <button @click="showCreate = true"
                class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouveau niveau
        </button>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Libellé</th>
                        <th class="px-4 py-3 text-left font-semibold">Département</th>
                        <th class="px-4 py-3 text-left font-semibold">Spécialité</th>
                        <th class="px-4 py-3 text-left font-semibold">Année</th>
                        <th class="px-4 py-3 text-left font-semibold">Statut</th>
                        <th class="px-4 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($niveaux as $niveau)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 font-semibold text-brand-700">{{ $niveau->libelle }}</td>
                            <td class="px-4 py-3">{{ $niveau->departement?->libelle ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $niveau->specialite?->libelle ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $niveau->anneeAcademique?->libelle ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ ($niveau->est_actif ?? true) ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ($niveau->est_actif ?? true) ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <button @click="editItem = {{ $niveau->toJson() }}; showEdit = true"
                                        class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:opacity-80 inline-flex items-center justify-center ml-1">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>
                                <form method="POST" action="{{ route('niveaux.destroy', $niveau) }}" class="inline"
                                      onsubmit="return confirm('Supprimer ce niveau ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:opacity-80 inline-flex items-center justify-center ml-1">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                <i class="fa-solid fa-layer-group text-3xl text-slate-300 mb-2"></i>
                                <p>Aucun niveau trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $niveaux->links() }}</div>

    {{-- Create Modal --}}
    <div x-show="showCreate" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
        <div @click="showCreate = false" class="absolute inset-0 bg-black/50"></div>
        <div x-transition class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Nouveau niveau</h3>
                <button @click="showCreate = false" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form method="POST" action="{{ route('niveaux.store') }}" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé</label>
                    <input name="libelle" type="text" required placeholder="ex: Licence 1" class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none"/>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Département</label>
                    <select name="departement_id" required class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                        <option value="">Sélectionner...</option>
                        @foreach($departements as $dep) <option value="{{ $dep->id }}">{{ $dep->libelle }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité</label>
                    <select name="specialite_id" class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                        <option value="">Aucune</option>
                        @foreach($specialites as $spec) <option value="{{ $spec->id }}">{{ $spec->libelle }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Année académique</label>
                    <select name="annee_academique_id" required class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                        <option value="">Sélectionner...</option>
                        @foreach($annees as $annee) <option value="{{ $annee->id }}">{{ $annee->libelle }}</option> @endforeach
                    </select>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showCreate = false" class="flex-1 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50">Annuler</button>
                    <button type="submit" class="flex-1 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow">Créer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-show="showEdit" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none">
        <div @click="showEdit = false" class="absolute inset-0 bg-black/50"></div>
        <div x-transition class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Modifier le niveau</h3>
                <button @click="showEdit = false" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form :action="'{{ url('niveaux') }}/' + editItem.id" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé</label>
                    <input name="libelle" type="text" required x-model="editItem.libelle" class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none"/>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Département</label>
                    <select name="departement_id" required x-model="editItem.departement_id" class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                        @foreach($departements as $dep) <option value="{{ $dep->id }}">{{ $dep->libelle }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité</label>
                    <select name="specialite_id" x-model="editItem.specialite_id" class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                        <option value="">Aucune</option>
                        @foreach($specialites as $spec) <option value="{{ $spec->id }}">{{ $spec->libelle }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Année académique</label>
                    <select name="annee_academique_id" required x-model="editItem.annee_academique_id" class="mt-1 w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl">
                        @foreach($annees as $annee) <option value="{{ $annee->id }}">{{ $annee->libelle }}</option> @endforeach
                    </select>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showEdit = false" class="flex-1 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50">Annuler</button>
                    <button type="submit" class="flex-1 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
