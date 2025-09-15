@extends('layout.main')

@section('css')
<style>
    .error-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-family: 'Poppins', sans-serif;
    }

    .error-container {
        text-align: center;
        max-width: 600px;
        padding: 40px 20px;
    }

    .error-code {
        font-size: 8rem;
        font-weight: 900;
        color: #EC281C;
        margin-bottom: 20px;
        text-shadow: 0 4px 8px rgba(236, 40, 28, 0.3);
        line-height: 1;
    }

    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
    }

    .error-description {
        font-size: 1.2rem;
        color: #718096;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .error-actions {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .error-btn {
        padding: 15px 30px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .error-btn-primary {
        background: #EC281C;
        color: white;
        border: 2px solid #EC281C;
    }

    .error-btn-primary:hover {
        background: #d63031;
        border-color: #d63031;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(236, 40, 28, 0.3);
    }

    .error-btn-secondary {
        background: transparent;
        color: #EC281C;
        border: 2px solid #EC281C;
    }

    .error-btn-secondary:hover {
        background: #EC281C;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(236, 40, 28, 0.3);
    }

    .error-illustration {
        margin-bottom: 40px;
    }

    .error-illustration svg {
        max-width: 300px;
        height: auto;
    }

    .error-details {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin: 30px 0;
        border-left: 4px solid #EC281C;
        text-align: left;
    }

    .error-details h4 {
        color: #EC281C;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .error-details p {
        color: #718096;
        margin: 0;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .error-code {
            font-size: 6rem;
        }

        .error-title {
            font-size: 2rem;
        }

        .error-description {
            font-size: 1.1rem;
        }

        .error-actions {
            flex-direction: column;
            align-items: center;
        }

        .error-btn {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <div class="error-page">
        <div class="error-container">
            <div class="error-illustration">
                <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Background circle -->
                    <circle cx="200" cy="150" r="120" fill="#fff5f5" stroke="#EC281C" stroke-width="2"/>
                    
                    <!-- 500 Text -->
                    <text x="200" y="140" text-anchor="middle" font-family="Arial, sans-serif" font-size="48" font-weight="bold" fill="#EC281C">500</text>
                    
                    <!-- Warning icon -->
                    <path d="M 200 100 L 180 140 L 220 140 Z" fill="#EC281C"/>
                    <circle cx="200" cy="130" r="3" fill="white"/>
                    
                    <!-- Server icon -->
                    <rect x="280" y="100" width="30" height="40" rx="4" fill="none" stroke="#EC281C" stroke-width="2"/>
                    <rect x="285" y="105" width="20" height="2" fill="#EC281C"/>
                    <rect x="285" y="110" width="20" height="2" fill="#EC281C"/>
                    <rect x="285" y="115" width="20" height="2" fill="#EC281C"/>
                </svg>
            </div>

            <div class="error-code">500</div>
            <h1 class="error-title">Erreur serveur</h1>
            <p class="error-description">
                Une erreur interne s'est produite sur notre serveur. 
                Notre équipe technique a été notifiée et travaille à résoudre le problème.
            </p>

            <div class="error-details">
                <h4><i class="fas fa-info-circle"></i> Que faire maintenant ?</h4>
                <p>• Vérifiez votre connexion internet<br>
                • Rechargez la page dans quelques minutes<br>
                • Contactez-nous si le problème persiste</p>
            </div>

            <div class="error-actions">
                <a href="{{ route('index') }}" class="error-btn error-btn-primary">
                    <i class="fas fa-home"></i>
                    Retour à l'accueil
                </a>
                <a href="{{ route('contact') }}" class="error-btn error-btn-secondary">
                    <i class="fas fa-envelope"></i>
                    Nous contacter
                </a>
                <button onclick="location.reload()" class="error-btn error-btn-secondary">
                    <i class="fas fa-redo"></i>
                    Recharger
                </button>
            </div>
        </div>
    </div>

    @include('includes.main.footer')
</body>
@endsection

@section('js')
<script>
    // Animation d'entrée
    document.addEventListener('DOMContentLoaded', function() {
        const errorContainer = document.querySelector('.error-container');
        errorContainer.style.opacity = '0';
        errorContainer.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            errorContainer.style.transition = 'all 0.6s ease';
            errorContainer.style.opacity = '1';
            errorContainer.style.transform = 'translateY(0)';
        }, 100);
    });
</script>
@endsection
