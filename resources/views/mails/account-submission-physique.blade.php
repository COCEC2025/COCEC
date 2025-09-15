<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande d'ouverture de compte - Personne Physique</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background-color: #EC281C; color: white; padding: 20px; text-align: center; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .section h3 { color: #EC281C; margin-top: 0; }
        .field { margin: 10px 0; }
        .field-label { font-weight: bold; color: #555; }
        .field-value { margin-left: 10px; }
        .null-value { color: #999; font-style: italic; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f5f5f5; }
        .footer { margin-top: 30px; padding: 20px; background-color: #f9f9f9; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>COCEC - Nouvelle demande d'ouverture de compte</h1>
            <h2>Personne Physique</h2>
        </div>

        <div class="section">
            <h3>Informations d'identité</h3>
            <div class="field">
                <span class="field-label">Nom :</span>
                <span class="field-value">{{ $data['last_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Prénoms :</span>
                <span class="field-value">{{ $data['first_names'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Genre :</span>
                <span class="field-value">{{ $data['gender'] == 'M' ? 'Masculin' : ($data['gender'] == 'F' ? 'Féminin' : 'Non renseigné') }}</span>
            </div>
            <div class="field">
                <span class="field-label">Date de naissance :</span>
                <span class="field-value">{{ $data['birth_date'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Lieu de naissance :</span>
                <span class="field-value">{{ $data['birth_place'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nationalité :</span>
                <span class="field-value">{{ $data['nationality'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nom du père :</span>
                <span class="field-value">{{ $data['father_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nom de la mère :</span>
                <span class="field-value">{{ $data['mother_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Téléphone :</span>
                <span class="field-value">{{ $data['phone'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Catégorie :</span>
                <span class="field-value">{{ $data['category'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">État civil :</span>
                <span class="field-value">{{ $data['marital_status'] ?? 'Non renseigné' }}</span>
            </div>
            @if($data['spouse_name'])
            <div class="field">
                <span class="field-label">Nom du conjoint :</span>
                <span class="field-value">{{ $data['spouse_name'] }}</span>
            </div>
            <div class="field">
                <span class="field-label">Profession du conjoint :</span>
                <span class="field-value">{{ $data['spouse_occupation'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Téléphone du conjoint :</span>
                <span class="field-value">{{ $data['spouse_phone'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Adresse du conjoint :</span>
                <span class="field-value">{{ $data['spouse_address'] ?? 'Non renseigné' }}</span>
            </div>
            @endif
        </div>

        <div class="section">
            <h3>Informations professionnelles</h3>
            <div class="field">
                <span class="field-label">Profession :</span>
                <span class="field-value">{{ $data['occupation'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nom de l'entreprise :</span>
                <span class="field-value">{{ $data['company_name_activity'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Type d'activité :</span>
                <span class="field-value">{{ $data['activity_type'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Description de l'activité :</span>
                <span class="field-value">{{ $data['activity_description'] ?? 'Non renseigné' }}</span>
            </div>
        </div>

        @if(isset($data['loc_method_residence']) && $data['loc_method_residence'])
        <div class="section">
            <h3>Adresse de résidence</h3>
            <div class="field">
                <span class="field-label">Méthode de localisation :</span>
                <span class="field-value">{{ $data['loc_method_residence'] == 'description' ? 'Description' : 'Carte' }}</span>
            </div>
            @if($data['loc_method_residence'] == 'description' && isset($data['residence_description']))
            <div class="field">
                <span class="field-label">Adresse :</span>
                <span class="field-value">{{ $data['residence_description'] ?? 'Non renseigné' }}</span>
            </div>
            @endif
            @if($data['loc_method_residence'] == 'map' && isset($data['residence_lat']) && isset($data['residence_lng']) && $data['residence_lat'] && $data['residence_lng'])
            <div class="field">
                <span class="field-label">Coordonnées GPS :</span>
                <span class="field-value">{{ $data['residence_lat'] }}, {{ $data['residence_lng'] }}</span>
            </div>
            @endif
        </div>
        @endif

        @if(isset($data['loc_method_workplace']) && $data['loc_method_workplace'])
        <div class="section">
            <h3>Adresse du lieu de travail</h3>
            <div class="field">
                <span class="field-label">Méthode de localisation :</span>
                <span class="field-value">{{ $data['loc_method_workplace'] == 'description' ? 'Description' : 'Carte' }}</span>
            </div>
            @if($data['loc_method_workplace'] == 'description' && isset($data['workplace_description']))
            <div class="field">
                <span class="field-label">Adresse :</span>
                <span class="field-value">{{ $data['workplace_description'] ?? 'Non renseigné' }}</span>
            </div>
            @endif
            @if($data['loc_method_workplace'] == 'map' && isset($data['workplace_lat']) && isset($data['workplace_lng']) && $data['workplace_lat'] && $data['workplace_lng'])
            <div class="field">
                <span class="field-label">Coordonnées GPS :</span>
                <span class="field-value">{{ $data['workplace_lat'] }}, {{ $data['workplace_lng'] }}</span>
            </div>
            @endif
        </div>
        @endif

        <div class="section">
            <h3>Pièce d'identité</h3>
            <div class="field">
                <span class="field-label">Type de pièce :</span>
                <span class="field-value">{{ $data['id_type'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Numéro de pièce :</span>
                <span class="field-value">{{ $data['id_number'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Date d'émission :</span>
                <span class="field-value">{{ $data['id_issue_date'] ?? 'Non renseigné' }}</span>
            </div>
        </div>

        <div class="section">
            <h3>Informations financières</h3>
            <div class="field">
                <span class="field-label">Dépôt initial :</span>
                <span class="field-value">{{ number_format($data['initial_deposit'], 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="field">
                <span class="field-label">Date d'adhésion :</span>
                <span class="field-value">{{ $data['membership_date'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Numéro de compte :</span>
                <span class="field-value">{{ $data['account_number'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Date d'ouverture de compte :</span>
                <span class="field-value">{{ $data['account_opening_date'] ?? 'Non renseigné' }}</span>
            </div>
        </div>

        <div class="section">
            <h3>Personne politiquement exposée (PPE)</h3>
            <div class="field">
                <span class="field-label">PPE national :</span>
                <span class="field-value">{{ $data['is_ppe_national'] ? 'Oui' : 'Non' }}</span>
            </div>
            <div class="field">
                <span class="field-label">PPE étranger :</span>
                <span class="field-value">{{ $data['ppe_foreign'] ? 'Oui' : 'Non' }}</span>
            </div>
        </div>

        @if($data['sanctions'] || $data['terrorism_financing'])
        <div class="section">
            <h3>Informations de conformité</h3>
            @if($data['sanctions'])
            <div class="field">
                <span class="field-label">Sanctions :</span>
                <span class="field-value">{{ $data['sanctions'] }}</span>
            </div>
            @endif
            @if($data['terrorism_financing'])
            <div class="field">
                <span class="field-label">Financement du terrorisme :</span>
                <span class="field-value">{{ $data['terrorism_financing'] }}</span>
            </div>
            @endif
        </div>
        @endif

        @if($data['remarks'])
        <div class="section">
            <h3>Remarques</h3>
            <div class="field">
                <span class="field-value">{{ $data['remarks'] }}</span>
            </div>
        </div>
        @endif

        @if($references && $references->count() > 0)
        <div class="section">
            <h3>Personnes de référence</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($references as $reference)
                    <tr>
                        <td>{{ $reference->name }}</td>
                        <td>{{ $reference->phone }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if($beneficiaries && $beneficiaries->count() > 0)
        <div class="section">
            <h3>Bénéficiaires</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Contact</th>
                        <th>Lien</th>
                        <th>Date de naissance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beneficiaries as $beneficiary)
                    <tr>
                        <td>{{ $beneficiary->nom }}</td>
                        <td>{{ $beneficiary->contact }}</td>
                        <td>{{ $beneficiary->lien }}</td>
                        <td>{{ $beneficiary->birth_date ?? 'Non renseigné' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div style="text-align: center; margin: 20px 0;">
            <a href="https://www.cocectogo.org/admin" style="display: inline-block; padding: 12px 30px; background-color: #EC281C; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Se connecter à l'interface admin
            </a>
        </div>

        <div class="footer">
            <p><strong>COCEC - Service Comptes</strong></p>
            <p>Site web : <a href="https://www.cocectogo.org" style="color: #EC281C;">www.cocectogo.org</a></p>
            <p>Cette demande a été soumise le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>

