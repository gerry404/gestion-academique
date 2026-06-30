{{-- resources/views/etablissement/departements/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Départements - EduManager')

@php
    $pageTitle = 'Départements / Filières';
    $pageSub = 'Structure académique de votre établissement';
@endphp

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="relative max-w-sm flex-1">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <input 
            type="text" 
            placeholder="Rechercher un département..." 
            class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"
            id="searchInput"
            onkeyup="filterTable()"
        />
    </div>
    <div class="flex gap-2 flex-wrap">
        <button onclick="toast('Export PDF lancé', 'info')" class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
            <i class="fa-solid fa-file-pdf text-red-500"></i> PDF
        </button>
        <button onclick="toast('Export Excel lancé', 'info')" class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
            <i class="fa-solid fa-file-excel text-green-600"></i> Excel
        </button>
        <a href="{{ route('departements.create') }}" class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouveau département
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm" id="departementsTable">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Code</th>
                    <th class="px-4 py-3 text-left font-semibold">Libellé</th>
                    <th class="px-4 py-3 text-left font-semibold">Chef de département</th>
                    <th class="px-4 py-3 text-left font-semibold">Spécialités</th>
                    <th class="px-4 py-3 text-left font-semibold">Statut</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($departements as $departement)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700">{{ $departement->code }}</td>
                    <td class="px-4 py-3 font-medium">{{ $departement->libelle }}</td>
                    <td class="px-4 py-3">
                        {{ $departement->chefDepartement?->nom_complet ?? 'Non défini' }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            {{ $departement->specialites->count() }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $departement->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $departement->est_actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('departements.show', $departement) }}" class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:opacity-80 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('departements.edit', $departement) }}" class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:opacity-80 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <button onclick="deleteDepartement({{ $departement->id }})" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:opacity-80 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                        <i class="fa-solid fa-building-columns text-4xl text-slate-300 mb-2 block"></i>
                        Aucun département trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $departements->links() }}
</div>

@push('scripts')
<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('departementsTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        for (let j = 0; j < cells.length - 1; j++) {
            const text = cells[j].textContent || cells[j].innerText;
            if (text.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        rows[i].style.display = found ? '' : 'none';
    }
}

function deleteDepartement(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce département ?')) {
        fetch(`/departements/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                toast('Département supprimé avec succès', 'success');
                location.reload();
            } else {
                toast(data.message || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(() => toast('Erreur lors de la suppression', 'error'));
    }
}
</script>
@endpush
@endsection