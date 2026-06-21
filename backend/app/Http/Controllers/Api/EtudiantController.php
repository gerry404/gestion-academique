<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etudiant\StoreEtudiantRequest;
use App\Http\Requests\Etudiant\UpdateEtudiantRequest;
use App\Models\Etudiant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Etudiant::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('matricule', 'like', "%{$search}%")
                    ->orWhere('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        $etudiants = $query->orderBy('nom')->orderBy('prenom')->get();

        return response()->json(['data' => $etudiants]);
    }

    public function store(StoreEtudiantRequest $request): JsonResponse
    {
        $etudiant = Etudiant::create($request->validated());

        return response()->json(['data' => $etudiant], 201);
    }

    public function show(Etudiant $etudiant): JsonResponse
    {
        return response()->json(['data' => $etudiant]);
    }

    public function update(UpdateEtudiantRequest $request, Etudiant $etudiant): JsonResponse
    {
        $etudiant->update($request->validated());

        return response()->json(['data' => $etudiant]);
    }

    public function destroy(Etudiant $etudiant): JsonResponse
    {
        $etudiant->delete();

        return response()->json(['message' => 'Etudiant supprime.']);
    }
}
