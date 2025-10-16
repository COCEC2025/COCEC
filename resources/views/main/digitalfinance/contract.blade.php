@extends('layout.main')

@section('css')
<style>
    .contract-container {
        min-height: 100vh;
        padding: 40px 0;
    }

    .contract-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-top: 4px solid #EC281C;
        overflow: hidden;
        max-width: 1000px;
        margin: 0 auto;
    }

    .contract-header {

        color: white;
        padding: 30px;
        text-align: center;
    }

    .contract-header h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--bz-color-theme-green);
    }

    .contract-header .subtitle {
        margin: 10px 0 0 0;
        font-size: 1rem;
        opacity: 0.9;
    }

    .contract-body {
        padding: 40px;
    }

    .contract-section {
        margin-bottom: 40px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 15px;

    }

    .section-title {
        color: #2d3748;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
    }

    .contract-text {
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 20px;
        text-align: justify;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #4a5568;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;

        box-shadow: 0 0 0 3px rgba(236, 40, 28, 0.15);
    }

    .form-input.error {

        box-shadow: 0 0 0 3px rgba(236, 40, 28, 0.15);
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .checkbox-group input[type="checkbox"] {
        margin-right: 10px;
        transform: scale(1.2);

    }

    .checkbox-group label {
        color: #4a5568;
        font-weight: 500;
        cursor: pointer;
    }

    .services-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    .service-category {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
    }

    .service-category h4 {
        color: #2d3748;
        margin-bottom: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
        padding-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
    }

    .submit-btn {
        background: #EC281C;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 20px;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(236, 40, 28, 0.3);
    }

    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .info-box {
        background: #e6f3ff;
        border: 1px solid #b3d9ff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .info-box h3 {
        color: #0066cc;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }

    .info-box p {
        color: #4a5568;
        margin-bottom: 10px;
    }

    .error-message {

        font-size: 0.85rem;
        margin-top: 5px;
        display: block;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .contract-body {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">Contrat d'adhésion à la finance digitale</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contrat finance digitale</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <div class="contract-container">
        <div class="contract-card">
            <div class="contract-header">
                <h1>CONTRAT D'ADHÉSION À LA FINANCE DIGITALE</h1>
                <p class="subtitle">COCEC - Services financiers numériques</p>
            </div>

            <div class="contract-body">
                <!-- FORMULAIRE DE SOUSCRIPTION -->
                <div class="contract-section">

                    <form action="{{ route('digitalfinance.contracts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name" class="form-label">Nom et prénoms *</label>
                                <input type="text" id="full_name" name="full_name" class="form-input @error('full_name') error @enderror" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="form-label">Téléphone *</label>
                                <input type="tel" id="phone" name="phone" class="form-input @error('phone') error @enderror" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="cni_type" class="form-label">Type de document</label>
                                <select id="cni_type" name="cni_type" class="form-input @error('cni_type') error @enderror">
                                    <option value="">Sélectionner...</option>
                                    <option value="CNI" {{ old('cni_type') == 'CNI' ? 'selected' : '' }}>CNI</option>
                                    <option value="Passeport" {{ old('cni_type') == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                                    <option value="Permis de conduire" {{ old('cni_type') == 'Permis de conduire' ? 'selected' : '' }}>Permis de conduire</option>
                                    <option value="Autre" {{ old('cni_type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('cni_type')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="cni_number" class="form-label">Numéro de document *</label>
                                <input type="text" id="cni_number" name="cni_number" class="form-input @error('cni_number') error @enderror" value="{{ old('cni_number') }}" required>
                                @error('cni_number')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="address" class="form-label">Adresse *</label>
                                <input type="text" id="address" name="address" class="form-input @error('address') error @enderror" value="{{ old('address') }}" required>
                                @error('address')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="account_number" class="form-label">Numéro de compte *</label>
                                <input type="text" id="account_number" name="account_number" class="form-input @error('account_number') error @enderror" value="{{ old('account_number') }}" required>
                                @error('account_number')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- SERVICES DIGITAUX -->
                        <div class="contract-section">

                            <div class="info-box">
                                <h3>Services disponibles</h3>
                                <p><strong>Mobile Money :</strong> Consultation de solde, mini relevé, dépôts/retraits, transferts</p>
                                <p><strong>Mobile Banking :</strong> Toutes les opérations Mobile Money + demandes de crédit</p>
                                <p><strong>Web Banking :</strong> Accès via navigateur web pour toutes les opérations</p>
                                <p><strong>SMS Banking :</strong> Alertes et notifications par SMS</p>
                            </div>

                            <div class="services-grid">
                                <div class="service-category">
                                    <h4>MOBILE MONEY</h4>
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="mobile_money" name="mobile_money" value="1" {{ old('mobile_money') ? 'checked' : '' }}>
                                        <label for="mobile_money">Souscrire au service Mobile Money</label>
                                    </div>
                                    <p style="font-size: 0.9rem; color: #666; margin-top: 10px;">
                                        <strong>Coût :</strong> <span id="mobile_money_cost">1000 F/an</span>
                                    </p>
                                </div>

                                <div class="service-category">
                                    <h4>MOBILE BANKING</h4>
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="mobile_banking" name="mobile_banking" value="1" {{ old('mobile_banking') ? 'checked' : '' }}>
                                        <label for="mobile_banking">Souscrire au service Mobile Banking</label>
                                    </div>
                                    <p style="font-size: 0.9rem; color: #666; margin-top: 10px;">
                                        <strong>Coût :</strong> <span id="mobile_banking_cost">1000 F/an</span>
                                    </p>
                                </div>

                                <div class="service-category">
                                    <h4>WEB BANKING</h4>
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="web_banking" name="web_banking" value="1" {{ old('web_banking') ? 'checked' : '' }}>
                                        <label for="web_banking">Souscrire au service Web Banking</label>
                                    </div>
                                    <p style="font-size: 0.9rem; color: #666; margin-top: 10px;">
                                        <strong>Coût :</strong> 600 F/an
                                    </p>
                                </div>

                                <div class="service-category">
                                    <h4>SMS BANKING</h4>
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="sms_banking" name="sms_banking" value="1" {{ old('sms_banking') ? 'checked' : '' }}>
                                        <label for="sms_banking">Souscrire au service SMS Banking</label>
                                    </div>
                                    <p style="font-size: 0.9rem; color: #666; margin-top: 10px;">
                                        <strong>Coût :</strong> 100 F/mois
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- NOTES -->
                        <div class="contract-section">
                            <h3 class="section-title">Notes additionnelles</h3>
                            <div class="form-group full-width">
                                <label for="notes" class="form-label">Commentaires ou demandes spéciales</label>
                                <textarea id="notes" name="notes" class="form-input" rows="4" placeholder="Vos commentaires...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="submit-btn" id="submit-btn">
                            Soumettre le contrat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('includes.main.scroll')
    @include('includes.main.footer')
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submit-btn');
    
    // Gestion des prix dynamiques pour Mobile Money + Mobile Banking
    const mobileMoneyCheckbox = document.getElementById('mobile_money');
    const mobileBankingCheckbox = document.getElementById('mobile_banking');
    const mobileMoneyCost = document.getElementById('mobile_money_cost');
    const mobileBankingCost = document.getElementById('mobile_banking_cost');
    
    function updatePricing() {
        const mobileMoneyChecked = mobileMoneyCheckbox.checked;
        const mobileBankingChecked = mobileBankingCheckbox.checked;
        
        if (mobileMoneyChecked && mobileBankingChecked) {
            // Si les deux sont sélectionnés : 1000 F pour les deux
            mobileMoneyCost.textContent = '1000 F/an';
            mobileBankingCost.textContent = '1000 F/an';
            
            // Ajouter un message d'information
            addComboMessage();
        } else if (mobileMoneyChecked || mobileBankingChecked) {
            // Si un seul est sélectionné : 1000 F chacun
            mobileMoneyCost.textContent = '1000 F/an';
            mobileBankingCost.textContent = '1000 F/an';
            removeComboMessage();
        } else {
            // Si aucun n'est sélectionné : prix normal
            mobileMoneyCost.textContent = '1000 F/an';
            mobileBankingCost.textContent = '1000 F/an';
            removeComboMessage();
        }
    }
    
    // Écouter les changements des checkboxes
    mobileMoneyCheckbox.addEventListener('change', updatePricing);
    mobileBankingCheckbox.addEventListener('change', updatePricing);
    
    // Initialiser les prix au chargement
    updatePricing();
    
    function addComboMessage() {
        // Supprimer l'ancien message s'il existe
        const existingMessage = document.getElementById('combo-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        // Créer le message d'information
        const messageDiv = document.createElement('div');
        messageDiv.id = 'combo-message';
        messageDiv.style.cssText = `
            background: linear-gradient(135deg, #fff5f5 0%, #ffeaea 100%);
            border: 2px solid #EC281C;
            border-radius: 12px;
            padding: 15px 20px;
            margin: 20px 0;
            text-align: center;
            font-weight: 600;
            color: #c53030;
            box-shadow: 0 4px 12px rgba(236, 40, 28, 0.15);
        `;
        messageDiv.innerHTML = `
            <i class="fas fa-gift" style="margin-right: 8px; color: #EC281C;"></i>
            <strong>Offre spéciale :</strong> Mobile Money + Mobile Banking = 1000 F/an au total
        `;
        
        // Insérer le message après la grille des services
        const servicesGrid = document.querySelector('.services-grid');
        servicesGrid.parentNode.insertBefore(messageDiv, servicesGrid.nextSibling);
    }
    
    function removeComboMessage() {
        const existingMessage = document.getElementById('combo-message');
        if (existingMessage) {
            existingMessage.remove();
        }
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Afficher le loading avec SweetAlert
            Swal.fire({
                title: 'Envoi en cours...',
                text: 'Veuillez patienter pendant l\'envoi de votre contrat',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));

            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
                            .then(({ status, body }) => {
                    // Fermer le loading
                    Swal.close();
                    
                    if (status === 200 || status === 201) {
                    Swal.fire({
                        icon: "success",
                        title: "Contrat soumis avec succès ! 🎉",
                        text: "Votre contrat d'adhésion a été enregistré. Nous vous contacterons bientôt.",
                        confirmButtonColor: "#EC281C",
                    }).then(() => {
                        form.reset();
                        // Nettoyer les erreurs
                        document.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));
                        document.querySelectorAll('.error-message').forEach(el => el.remove());
                    });
                } else if (status === 422) {
                    Object.keys(body.errors).forEach(field => {
                        const input = document.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('error');
                            const errorSpan = document.createElement('span');
                            errorSpan.className = 'error-message';
                            errorSpan.textContent = body.errors[field][0];
                            input.closest('.form-group').appendChild(errorSpan);
                        }
                    });
                    Swal.fire({
                        icon: "warning",
                        title: "Veuillez corriger les erreurs",
                        text: "Certains champs contiennent des erreurs. Veuillez les corriger et réessayer.",
                        confirmButtonColor: "#EC281C",
                    });
                } else {
                    throw new Error(body.message || 'Une erreur inattendue est survenue.');
                }
            })
                            .catch(error => {
                    // Fermer le loading en cas d'erreur
                    Swal.close();
                    
                    Swal.fire({
                    icon: "error",
                    title: "Oups...",
                    text: "Une erreur de communication est survenue. Veuillez réessayer plus tard.",
                    confirmButtonColor: "#EC281C",
                });
                            });
            });
        }
});
</script>
@endsection

