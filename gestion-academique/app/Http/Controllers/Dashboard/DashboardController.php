<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers\Dashboard;  // ✅ CORRIGER ICI

use App\Http\Controllers\Controller;  // ✅ AJOUTER CECI
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'etudiants' => 2547,
            'enseignants' => 128,
            'departements' => 12,
            'taux_reussite' => 87,
        ];

        return view('dashboard.index', compact('stats'));
    }
}