<!-- La structure complète de la popup/modale -->
<div id="popup-overlay" class="popup-overlay">
    <div class="popup-container">
        <!-- Bouton pour fermer la modale -->
        <button class="popup-close" aria-label="Fermer">×</button>

        <!-- Votre contenu original est maintenant ici à l'intérieur -->
        <section id="popup-data">
            @if(isset($announcement) && $announcement)
            <div id="popup-announcement" class="popup-content">
                <h2>{{ $announcement->title }}</h2>
                @if($announcement->image)
                <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($announcement->image) }}" alt="Annonce">
                @endif
                <p>{{ $announcement->description }}</p>
            </div>
            @else
            <!-- <div id="popup-newsletter" class="popup-content">
                <div class="popup-newsletter-header">
                    <h2>Inscrivez-vous à notre newsletter</h2>
                    <p>Recevez nos meilleures offres et actualités directement dans votre boîte mail.</p>
                </div>
                <form id="popup-newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Votre adresse e-mail" required>
                        <button type="submit">
                            <span class="btn-text">S'inscrire</span>
                            <span class="btn-loading" style="display: none;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Inscription...
                            </span>
                        </button>
                    </div>
                </form>
                <div class="popup-newsletter-footer">
                    <small>🔒 Vos données sont protégées et ne seront jamais partagées</small>
                </div>
            </div> -->
            @endif
        </section>
    </div>
</div>

<!-- Styles CSS pour le popup newsletter responsive -->
<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        backdrop-filter: blur(5px);
    }

    .popup-container {
        background: white;
        border-radius: 20px;
        max-width: 500px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: popupSlideIn 0.4s ease-out;
    }

    @keyframes popupSlideIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(50px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .popup-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #f8f9fa;
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        font-size: 20px;
        font-weight: bold;
        color: #6c757d;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .popup-close:hover {
        background: #EC281C;
        color: white;
        transform: rotate(90deg);
    }

    .popup-content {
        padding: 40px 30px 30px;
    }

    .popup-newsletter-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .popup-newsletter-header h2 {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 15px 0;
        line-height: 1.3;
    }

    .popup-newsletter-header p {
        color: #6c757d;
        font-size: 16px;
        margin: 0;
        line-height: 1.5;
    }

    .popup-newsletter .form-group {
        margin-bottom: 25px;
    }

    .popup-newsletter .form-group input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        font-size: 16px;
        transition: all 0.3s ease;
        margin-bottom: 15px;
        box-sizing: border-box;
    }

    .popup-newsletter .form-group input:focus {
        outline: none;
        border-color: #EC281C;
        box-shadow: 0 0 0 3px rgba(236, 40, 28, 0.1);
    }

    .popup-newsletter .form-group button {
        width: 100%;
        padding: 15px 30px;
        background: linear-gradient(135deg, #EC281C 0%, #d4241a 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .popup-newsletter .form-group button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(236, 40, 28, 0.3);
    }

    .popup-newsletter .form-group button:active {
        transform: translateY(0);
    }

    .popup-newsletter-footer {
        text-align: center;
        margin-top: 20px;
    }

    .popup-newsletter-footer small {
        color: #adb5bd;
        font-size: 12px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .popup-overlay {
            padding: 15px;
        }

        .popup-container {
            max-width: 100%;
            border-radius: 15px;
        }

        .popup-content {
            padding: 30px 20px 25px;
        }

        .popup-newsletter-header h2 {
            font-size: 24px;
        }

        .popup-newsletter-header p {
            font-size: 14px;
        }

        .popup-newsletter .form-group input {
            padding: 12px 18px;
            font-size: 15px;
        }

        .popup-newsletter .form-group button {
            padding: 12px 25px;
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .popup-overlay {
            padding: 10px;
        }

        .popup-container {
            border-radius: 12px;
        }

        .popup-content {
            padding: 25px 15px 20px;
        }

        .popup-newsletter-header h2 {
            font-size: 20px;
        }

        .popup-newsletter-header p {
            font-size: 13px;
        }

        .popup-close {
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            font-size: 18px;
        }
    }

    /* Animation de fermeture */
    .popup-overlay.closing {
        animation: popupFadeOut 0.3s ease-in;
    }

    .popup-container.closing {
        animation: popupSlideOut 0.3s ease-in;
    }

    @keyframes popupFadeOut {
        to {
            opacity: 0;
        }
    }

    @keyframes popupSlideOut {
        to {
            opacity: 0;
            transform: scale(0.8) translateY(50px);
        }
    }
</style>

<!-- Script pour le popup newsletter -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const popupOverlay = document.getElementById('popup-overlay');
    const popupContainer = document.querySelector('.popup-container');
    const closeBtn = document.querySelector('.popup-close');
    const newsletterForm = document.getElementById('popup-newsletter-form');

    // Vérifier si l'utilisateur a déjà vu le popup
    const popupShown = localStorage.getItem('newsletterPopupShown');
    const popupDismissed = localStorage.getItem('newsletterPopupDismissed');

    // Afficher le popup après 3 secondes si pas déjà vu ou refusé
    if (!popupShown && !popupDismissed) {
        setTimeout(() => {
            if (popupOverlay) {
                popupOverlay.style.display = 'flex';
            }
        }, 3000);
    }

    // Fermer le popup
    function closePopup() {
        if (popupOverlay && popupContainer) {
            popupOverlay.classList.add('closing');
            popupContainer.classList.add('closing');
            
            setTimeout(() => {
                popupOverlay.style.display = 'none';
                popupOverlay.classList.remove('closing');
                popupContainer.classList.remove('closing');
            }, 300);
        }
    }

    // Event listeners
    if (closeBtn) {
        closeBtn.addEventListener('click', closePopup);
    }

    if (popupOverlay) {
        popupOverlay.addEventListener('click', function(e) {
            if (e.target === popupOverlay) {
                closePopup();
            }
        });
    }

    // Gestion du formulaire newsletter
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');
            const email = this.querySelector('input[name="email"]').value;

            // Afficher le loading
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-block';
            submitBtn.disabled = true;

            // Simuler l'envoi (remplacer par votre logique AJAX)
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Succès
                    Swal.fire({
                        icon: 'success',
                        title: 'Inscription réussie !',
                        text: 'Merci de vous être inscrit à notre newsletter.',
                        confirmButtonColor: '#EC281C'
                    });
                    localStorage.setItem('newsletterPopupShown', 'true');
                    closePopup();
                } else {
                    throw new Error(data.message || 'Erreur lors de l\'inscription');
                }
            })
            .catch(error => {
                // Erreur
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: error.message || 'Une erreur est survenue. Veuillez réessayer.',
                    confirmButtonColor: '#EC281C'
                });
            })
            .finally(() => {
                // Restaurer le bouton
                btnText.style.display = 'inline-block';
                btnLoading.style.display = 'none';
                submitBtn.disabled = false;
            });
        });
    }

    // Marquer comme refusé si fermé sans inscription
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            localStorage.setItem('newsletterPopupDismissed', 'true');
        });
    }
});
</script>