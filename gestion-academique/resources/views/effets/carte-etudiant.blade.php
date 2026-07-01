{{-- Version ultra-simple avec boutons cachés dans le PDF --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carte d'étudiant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .card {
            width: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .card-top {
            background: #1a365d;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .card-top h2 { font-size: 18px; }
        .card-top span { font-size: 11px; background: #ecc94b; color: #1a365d; padding: 2px 12px; border-radius: 20px; font-weight: 700; }
        .card-body { padding: 20px; display: flex; gap: 15px; }
        .card-body .avatar { width: 90px; height: 110px; background: #edf2f7; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 40px; color: #a0aec0; flex-shrink: 0; overflow: hidden; }
        .card-body .avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
        .card-body .info { flex: 1; }
        .card-body .info .name { font-size: 16px; font-weight: 700; color: #1a365d; }
        .card-body .info .id { font-size: 12px; color: #718096; margin-bottom: 8px; }
        .card-body .info .row { display: flex; justify-content: space-between; font-size: 13px; padding: 3px 0; border-bottom: 1px dashed #e2e8f0; }
        .card-body .info .row .lbl { color: #718096; font-size: 11px; }
        .card-body .info .row:last-child { border-bottom: none; }
        .card-bottom { background: #f7fafc; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; }
        .card-bottom .valid { font-size: 10px; color: #718096; }
        .card-bottom .qr { width: 35px; height: 35px; background: #1a365d; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; }
        
        /* ✅ Boutons cachés lors de l'impression / PDF */
        .actions { 
            display: flex; 
            gap: 10px; 
            justify-content: center; 
            margin-top: 15px; 
            flex-wrap: wrap; 
        }
        .btn { 
            padding: 8px 16px; 
            border: none; 
            border-radius: 6px; 
            font-size: 12px; 
            font-weight: 600; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 5px; 
        }
        .btn-primary { background: #1a365d; color: white; }
        .btn-primary:hover { background: #0f2a4a; }
        .btn-success { background: #16a34a; color: white; }
        .btn-success:hover { background: #15803d; }
        .btn-secondary { background: #e2e8f0; color: #4a5568; }
        .btn-secondary:hover { background: #cbd5e0; }

        /* ✅ Cache les boutons à l'impression */
        @media print {
            .no-print { display: none !important; }
            .card { box-shadow: none !important; }
            body { background: white !important; padding: 0 !important; }
        }
    </style>
</head>
<body>
    <div>
        <!-- Carte -->
        <div class="card">
            <div class="card-top">
                <h2><i class="fas fa-graduation-cap"></i> EduManager</h2>
                <span>CARTE</span>
            </div>
            <div class="card-body">
                <div class="avatar">
                    @if($inscription->etudiant->photo)
                        <img src="{{ public_path('storage/' . $inscription->etudiant->photo) }}" alt="Photo">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="info">
                    <div class="name">{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</div>
                    <div class="id">Matricule: {{ $inscription->etudiant->matricule }}</div>
                    <div class="row"><span class="lbl">Niveau</span> <span>{{ $inscription->niveau->libelle ?? '-' }}</span></div>
                    <div class="row"><span class="lbl">Spécialité</span> <span>{{ $inscription->specialite->libelle ?? '-' }}</span></div>
                    <div class="row"><span class="lbl">Département</span> <span>{{ $inscription->departement->libelle ?? '-' }}</span></div>
                </div>
            </div>
            <div class="card-bottom">
                <div>
                    <div class="valid">Valable jusqu'au 31/12/{{ date('Y')+1 }}</div>
                    <div style="font-size:10px;color:#1a365d;font-weight:600;">N° {{ $inscription->etudiant->matricule }}</div>
                </div>
                <div class="qr"><i class="fas fa-qrcode"></i></div>
            </div>
        </div>

        <!-- ✅ Boutons avec la classe no-print -->
        <div class="actions no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Imprimer
            </button>
            <a href="{{ route('cartes.download', $inscription->id) }}" class="btn btn-success">
                <i class="fas fa-file-pdf"></i> Télécharger PDF
            </a>
            <a href="{{ route('cartes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>