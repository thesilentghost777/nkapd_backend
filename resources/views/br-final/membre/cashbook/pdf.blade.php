<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cahier de caisse — {{ $cashbook->libelle_mois }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; font-size: 12px; margin: 0; padding: 20px; }
        h1 { color: #ea580c; font-size: 20px; margin-bottom: 4px; }
        .subtitle { color: #666; margin-bottom: 20px; }
        .stats { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-box { flex: 1; border: 1px solid #eee; border-radius: 8px; padding: 12px; }
        .stat-box .label { color: #999; font-size: 10px; margin-bottom: 4px; }
        .stat-box .value { font-size: 16px; font-weight: bold; }
        .green { color: #16a34a; } .red { color: #dc2626; } .orange { color: #ea580c; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead th { background: #f8f8f8; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; border-bottom: 2px solid #eee; }
        td { padding: 8px; border-bottom: 1px solid #f0f0f0; }
        .footer { margin-top: 30px; text-align: center; color: #999; font-size: 10px; }
    </style>
</head>
<body>
    <h1>📊 Cahier de caisse — {{ $cashbook->libelle_mois }}</h1>
    <p class="subtitle">Propriétaire : {{ $cashbook->user->nom_complet }} · Exporté le {{ now()->format('d/m/Y à H:i') }}</p>

    <div class="stats">
        <div class="stat-box">
            <div class="label">Total entrées</div>
            <div class="value green">{{ number_format($cashbook->total_entrees ?? 0, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="stat-box">
            <div class="label">Total sorties</div>
            <div class="value red">{{ number_format($cashbook->total_sorties ?? 0, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="stat-box">
            <div class="label">Solde net</div>
            <div class="value orange">{{ number_format($cashbook->solde ?? 0, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Libellé</th>
                <th>Catégorie</th>
                <th style="text-align:right">Entrée (FCFA)</th>
                <th style="text-align:right">Sortie (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $e)
            <tr>
                <td>{{ \Carbon\Carbon::parse($e->date)->format('d/m/Y') }}</td>
                <td>{{ $e->libelle }}</td>
                <td>{{ $e->categorie ?? '—' }}</td>
                <td style="text-align:right; color:{{ $e->type === 'entree' ? '#16a34a' : '#ccc' }}">
                    {{ $e->type === 'entree' ? number_format($e->montant, 0, ',', ' ') : '' }}
                </td>
                <td style="text-align:right; color:{{ $e->type === 'sortie' ? '#dc2626' : '#ccc' }}">
                    {{ $e->type === 'sortie' ? number_format($e->montant, 0, ',', ' ') : '' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Business Room — Gestion financière communautaire</div>
</body>
</html>