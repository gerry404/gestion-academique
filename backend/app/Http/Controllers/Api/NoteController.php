<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Note::with(['etudiant', 'matiere']);

        if ($etudiant = $request->query('etudiant_id')) {
            $query->where('etudiant_id', $etudiant);
        }

        if ($matiere = $request->query('matiere_id')) {
            $query->where('matiere_id', $matiere);
        }

        return response()->json(['data' => $query->latest()->get()]);
    }

    public function store(StoreNoteRequest $request): JsonResponse
    {
        $note = Note::create($request->validated());
        $note->load(['etudiant', 'matiere']);

        return response()->json(['data' => $note], 201);
    }

    public function show(Note $note): JsonResponse
    {
        $note->load(['etudiant', 'matiere']);

        return response()->json(['data' => $note]);
    }

    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        $note->update($request->validated());
        $note->load(['etudiant', 'matiere']);

        return response()->json(['data' => $note]);
    }

    public function destroy(Note $note): JsonResponse
    {
        $note->delete();

        return response()->json(['message' => 'Note supprimee.']);
    }
}
