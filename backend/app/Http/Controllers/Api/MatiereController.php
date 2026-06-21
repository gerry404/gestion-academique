<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Matiere\StoreMatiereRequest;
use App\Http\Requests\Matiere\UpdateMatiereRequest;
use App\Models\Matiere;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Matiere::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        return response()->json(['data' => $query->orderBy('code')->get()]);
    }

    public function store(StoreMatiereRequest $request): JsonResponse
    {
        $matiere = Matiere::create($request->validated());

        return response()->json(['data' => $matiere], 201);
    }

    public function show(Matiere $matiere): JsonResponse
    {
        return response()->json(['data' => $matiere]);
    }

    public function update(UpdateMatiereRequest $request, Matiere $matiere): JsonResponse
    {
        $matiere->update($request->validated());

        return response()->json(['data' => $matiere]);
    }

    public function destroy(Matiere $matiere): JsonResponse
    {
        $matiere->delete();

        return response()->json(['message' => 'Matiere supprimee.']);
    }
}
