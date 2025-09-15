<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande d'ouverture de compte - Personne Morale</title>
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
            <h2>Personne Morale</h2>
        </div>

        <div class="section">
            <h3>Informations de l'entreprise</h3>
            <div class="field">
                <span class="field-label">Nom de l'entreprise :</span>
                <span class="field-value">{{ $data['company_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Catégorie :</span>
                <span class="field-value">{{ $data['category'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">RCCM :</span>
                <span class="field-value">{{ $data['rccm'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Type de pièce d'identité :</span>
                <span class="field-value">{{ $data['company_id_type'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Numéro de pièce :</span>
                <span class="field-value">{{ $data['company_id_number'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Date de délivrance :</span>
                <span class="field-value">{{ $data['company_id_date'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Date de création :</span>
                <span class="field-value">{{ $data['creation_date'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Lieu de création :</span>
                <span class="field-value">{{ $data['creation_place'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Secteur d'activité :</span>
                <span class="field-value">{{ $data['activity_sector'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Description de l'activité :</span>
                <span class="field-value">{{ $data['activity_description'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nationalité de l'entreprise :</span>
                <span class="field-value">{{ $data['company_nationality'] ?? 'Non renseigné' }}</span>
            </div>
        </div>

        <div class="section">
            <h3>Coordonnées de l'entreprise</h3>
            <div class="field">
                <span class="field-label">Téléphone :</span>
                <span class="field-value">{{ $data['company_phone'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Boîte postale :</span>
                <span class="field-value">{{ $data['company_postal_box'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Ville :</span>
                <span class="field-value">{{ $data['company_city'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Quartier :</span>
                <span class="field-value">{{ $data['company_neighborhood'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Adresse :</span>
                <span class="field-value">{{ $data['company_address'] ?? 'Non renseigné' }}</span>
            </div>
            @if($data['company_lat'] && $data['company_lng'])
            <div class="field">
                <span class="field-label">Coordonnées GPS :</span>
                <span class="field-value">{{ $data['company_lat'] }}, {{ $data['company_lng'] }}</span>
            </div>
            @endif
        </div>

        <div class="section">
            <h3>Informations du directeur</h3>
            <div class="field">
                <span class="field-label">Nom :</span>
                <span class="field-value">{{ $data['director_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Prénom :</span>
                <span class="field-value">{{ $data['director_first_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Poste :</span>
                <span class="field-value">{{ $data['director_position'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Genre :</span>
                <span class="field-value">{{ $data['director_gender'] == 'M' ? 'Masculin' : ($data['director_gender'] == 'F' ? 'Féminin' : 'Non renseigné') }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nationalité :</span>
                <span class="field-value">{{ $data['director_nationality'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Date de naissance :</span>
                <span class="field-value">{{ $data['director_birth_date'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Lieu de naissance :</span>
                <span class="field-value">{{ $data['director_birth_place'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Numéro de pièce d'identité :</span>
                <span class="field-value">{{ $data['director_id_number'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Date d'émission de la pièce :</span>
                <span class="field-value">{{ $data['director_id_issue_date'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Téléphone :</span>
                <span class="field-value">{{ $data['director_phone'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nom du père :</span>
                <span class="field-value">{{ $data['director_father_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Nom de la mère :</span>
                <span class="field-value">{{ $data['director_mother_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Boîte postale :</span>
                <span class="field-value">{{ $data['director_postal_box'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Ville :</span>
                <span class="field-value">{{ $data['director_city'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Quartier :</span>
                <span class="field-value">{{ $data['director_neighborhood'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Adresse :</span>
                <span class="field-value">{{ $data['director_address'] ?? 'Non renseigné' }}</span>
            </div>
        </div>

        @if($data['director_spouse_name'])
        <div class="section">
            <h3>Informations du conjoint du directeur</h3>
            <div class="field">
                <span class="field-label">Nom :</span>
                <span class="field-value">{{ $data['director_spouse_name'] }}</span>
            </div>
            <div class="field">
                <span class="field-label">Profession :</span>
                <span class="field-value">{{ $data['director_spouse_occupation'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Téléphone :</span>
                <span class="field-value">{{ $data['director_spouse_phone'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Adresse :</span>
                <span class="field-value">{{ $data['director_spouse_address'] ?? 'Non renseigné' }}</span>
            </div>
        </div>
        @endif

        <div class="section">
            <h3>Informations administratives</h3>
            <div class="field">
                <span class="field-label">Composition des membres :</span>
                <span class="field-value">{{ $data['minutes_members'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Procès-verbal de réunion :</span>
                <span class="field-value">{{ $data['minutes_meeting'] ?? 'Non renseigné' }}</span>
            </div>
        </div>

        <div class="section">
            <h3>Contact d'urgence</h3>
            <div class="field">
                <span class="field-label">Nom :</span>
                <span class="field-value">{{ $data['emergency_contact_name'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Téléphone :</span>
                <span class="field-value">{{ $data['emergency_contact_phone'] ?? 'Non renseigné' }}</span>
            </div>
            <div class="field">
                <span class="field-label">Adresse :</span>
                <span class="field-value">{{ $data['emergency_contact_address'] ?? 'Non renseigné' }}</span>
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
