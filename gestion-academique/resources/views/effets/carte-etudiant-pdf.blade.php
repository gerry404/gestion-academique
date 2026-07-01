{{-- resources/views/effets/carte-etudiant-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carte d'étudiant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            background: white;
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
            border: 1px solid #e2e8f0;
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
        
        /* ✅ Aucun bouton dans le PDF */
        .no-print { display: none !important; }
    </style>
</head>
<body>
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
</body>
</html>