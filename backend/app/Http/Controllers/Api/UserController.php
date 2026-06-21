<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = User::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('name')->get();

        return response()->json(['data' => $users]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json(['data' => $user], 201);
    }

    public function show(User $utilisateur): JsonResponse
    {
        return response()->json(['data' => $utilisateur]);
    }

    public function update(UpdateUserRequest $request, User $utilisateur): JsonResponse
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $utilisateur->update($data);

        return response()->json(['data' => $utilisateur]);
    }

    public function destroy(Request $request, User $utilisateur): JsonResponse
    {
        if ($request->user()->id === $utilisateur->id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas supprimer votre propre compte.',
            ], 422);
        }

        $utilisateur->delete();

        return response()->json(['message' => 'Utilisateur supprime.']);
    }
}
