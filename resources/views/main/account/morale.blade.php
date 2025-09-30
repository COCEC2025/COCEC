@extends('layout.main')

@section('css')
{{-- CSS pour la carte interactive Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
{{-- SweetAlert2 pour les messages de succès/erreur --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .account-form-section {
        background-color: #f7f8fc;
        font-family: 'Poppins', sans-serif;
    }

    .form-container {
        max-width: 900px;
        margin: 0 auto;
        background: #FFFFFF;
        border-radius: 16px;
        padding: 40px 50px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border-top: 5px solid #EC281C;
    }

    .section-heading h2 {
        font-weight: 700;
        color: #000000;
    }

    .section-heading p {
        color: #555;
        line-height: 1.7;
    }

    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
    }

    .nav-tabs .nav-item {
        margin-bottom: -2px;
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        color: #6c757d;
        font-weight: 500;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #000000;
    }

    .nav-tabs .nav-link.active {
        background-color: transparent;
        color: #EC281C;
        font-weight: 600;
        border-color: #EC281C;
    }

    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 35px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .input-group-custom {
        position: relative;
    }

    .input-group-custom .form-label {
        font-weight: 500;
        color: #343a40;
        margin-bottom: 8px;
    }

    .input-group-custom .form-control {
        border-radius: 8px;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .form-stepper {
        display: flex;
        justify-content: space-around;
        width: 100%;
        position: relative;
        margin: 30px 0;
    }

    .form-stepper .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .form-stepper .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 0.3s ease;
        border: 3px solid #e0e0e0;
    }

    .form-stepper .step-label {
        margin-top: 10px;
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 500;
    }

    .form-stepper .step.active .step-icon,
    .form-stepper .step.completed .step-icon {
        background: #EC281C;
        border-color: #EC281C;
    }

    .form-stepper .step.active .step-label {
        color: #EC281C;
        font-weight: 600;
    }

    .form-stepper::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #e0e0e0;
        transform: translateY(-50%);
        z-index: 0;
    }

    .form-stepper .progress-line {
        position: absolute;
        top: 20px;
        left: 0;
        height: 2px;
        background-color: #EC281C;
        transform: translateY(-50%);
        z-index: 0;
        width: 0%;
        transition: width 0.4s ease;
    }

    .form-step-content {
        display: none;
    }

    .form-step-content.active {
        display: block;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-navigation-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        gap: 20px;
    }

    .btn-nav {
        padding: 15px 35px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        min-width: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .btn-nav:active {
        transform: translateY(0);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-nav:hover::before {
        left: 100%;
    }

    .btn-prev {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white !important;
        border: 2px solid #6c757d;
    }

    .btn-prev:hover {
        background: linear-gradient(135deg, #495057, #343a40);
        border-color: #495057;
        color: white !important;
    }

    .btn-next {
        background: linear-gradient(135deg, #EC281C, #d4241a);
        color: white !important;
        border: 2px solid #EC281C;
    }

    .btn-next:hover {
        background: linear-gradient(135deg, #d4241a, #b91c13);
        border-color: #d4241a;
        color: white !important;
    }

    .btn-submit-form {
        font-size: 1.1rem;
        border-radius: 12px;
        padding: 18px 40px;
        width: auto;
        background: linear-gradient(135deg, #EC281C, #d4241a);
        color: white !important;
        border: 2px solid #EC281C;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(236, 40, 28, 0.3);
        transition: all 0.3s ease;
        cursor: pointer;
        min-width: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit-form:hover {
        background: linear-gradient(135deg, #d4241a, #b91c13);
        border-color: #d4241a;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(236, 40, 28, 0.4);
        color: white !important;
    }

    .btn-submit-form:active {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(236, 40, 28, 0.3);
        color: white !important;
    }

    .btn-submit-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s;
    }

    .btn-submit-form:hover::before {
        left: 100%;
    }

    /* Styles responsifs pour les boutons */
    @media (max-width: 768px) {
        .form-navigation-buttons {
            flex-direction: column;
            gap: 15px;
        }

        .btn-nav, .btn-submit-form {
            width: 100%;
            min-width: auto;
            padding: 18px 25px;
        }

        .btn-nav {
            font-size: 0.95rem;
        }

        .btn-submit-form {
            font-size: 1rem;
            padding: 20px 30px;
        }
    }

    /* Animation d'apparition des boutons */
    .btn-nav, .btn-submit-form {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Effet de focus pour l'accessibilité */
    .btn-nav:focus, .btn-submit-form:focus {
        outline: 3px solid rgba(236, 40, 28, 0.5);
        outline-offset: 2px;
    }

    /* État désactivé */
    .btn-nav:disabled, .btn-submit-form:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    .btn-nav:disabled:hover, .btn-submit-form:disabled:hover {
        transform: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: border-color 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .file-upload-wrapper:hover {
        border-color: #EC281C;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-icon {
        color: #EC281C;
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .file-upload-text {
        font-weight: 500;
        color: #555;
    }

    .file-upload-preview span {
        font-style: italic;
        color: #000;
        font-weight: 500;
    }

    /* Styles améliorés pour la prévisualisation des images */
    .file-upload-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .file-upload-preview img:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        border-color: #EC281C;
    }

    .file-upload-preview .preview-container {
        position: relative;
        display: inline-block;
        margin-top: 10px;
    }

    .file-upload-preview .remove-preview {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        transition: all 0.3s ease;
    }

    .file-upload-preview .remove-preview:hover {
        background: #c82333;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    .file-upload-preview .file-info {
        margin-top: 8px;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #EC281C;
        font-size: 0.9rem;
        color: #495057;
    }

    .file-upload-preview .file-info .file-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 4px;
    }

    .file-upload-preview .file-info .file-size {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .choice-container .choice-label {
        display: block;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .choice-container input[type="radio"] {
        display: none;
    }

    .choice-container input[type="radio"]:checked+.choice-label {
        border-color: #EC281C;
        background-color: #ec281c1a;
        font-weight: 600;
        color: #EC281C;
    }

    .method-area {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 8px;
        display: none;
    }

    #signature-pad-morale {
        border: 2px solid #f0f0f0;
        border-radius: 8px;
        width: 100%;
        height: 200px;
        cursor: crosshair;
        background-color: #fff;
    }

    .signature-controls {
        margin-top: 15px;
        text-align: right;
    }

    .map-container {
        height: 350px;
        border-radius: 8px;
        border: 1px solid #ddd;
        z-index: 1;
    }

    .btn-clear {
        background: #6c757d;
        color: white;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        border: none;
    }

    .versements-summary {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .versements-summary .row-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .versements-summary .label {
        color: #6c757d;
    }

    .versements-summary .value,
    .versements-summary .total-value {
        font-weight: 600;
        color: #000;
    }

    .versements-summary .total-row {
        border-top: 2px solid #343a40;
        margin-top: 10px;
        padding-top: 10px;
    }

    .versements-summary .total-label,
    .versements-summary .total-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #EC281C;
    }

    .form-control.is-invalid,
    .was-validated .form-control:invalid,
    .file-upload-wrapper.is-invalid,
    .choice-container.is-invalid .choice-label {
        border-color: #dc3545 !important;
    }

    .file-upload-wrapper.is-invalid {
        border-style: solid;
    }

    .form-control.is-invalid:focus,
    .was-validated .form-control:invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    /* Masquer les éléments de sélection SweetAlert2 inutiles */
    .nice-select.swal2-select {
        display: none !important;
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: .25rem;
        font-size: .875em;
        color: #dc3545;
    }

    .was-validated .form-control:invalid~.invalid-feedback,
    .form-control.is-invalid~.invalid-feedback,
    .choice-container.is-invalid+.invalid-feedback {
        display: block;
    }

    .dynamic-field {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        position: relative;
    }

    .dynamic-field .remove-field {
        top: 10px;
        right: 10px;
    }

    /* Style personnalisé pour les boutons "Ajouter" avec la charte graphique COCEC */
    .dynamic-adder-btn {
        background: linear-gradient(135deg, #EC281C, #d4241a) !important;
        color: white !important;
        border: 2px solid #EC281C !important;
        border-radius: 10px !important;
        padding: 12px 25px !important;
        font-weight: 600 !important;
        font-size: 0.95rem !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 15px rgba(236, 40, 28, 0.2) !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .dynamic-adder-btn:hover {
        background: linear-gradient(135deg, #d4241a, #b91c13) !important;
        border-color: #d4241a !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(236, 40, 28, 0.3) !important;
        text-decoration: none !important;
    }

    .dynamic-adder-btn:active {
        transform: translateY(0) !important;
        box-shadow: 0 4px 15px rgba(236, 40, 28, 0.2) !important;
    }

    .dynamic-adder-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .dynamic-adder-btn:hover::before {
        left: 100%;
    }

    .dynamic-adder-btn i {
        color: white !important;
        font-size: 1rem !important;
    }

    /* Styles pour les champs optionnels */
    .form-control[data-optional="true"] {
        border-color: #e0e0e0;
    }

    .form-control[data-optional="true"]:focus {
        border-color: #EC281C;
        box-shadow: 0 0 0 0.25rem rgba(236, 40, 28, 0.25);
    }

    /* S'assurer que le champ RCCM n'a pas de style d'erreur */
    .form-control[name="rccm"] {
        border-color: #e0e0e0 !important;
    }

    .form-control[name="rccm"]:focus {
        border-color: #EC281C !important;
        box-shadow: 0 0 0 0.25rem rgba(236, 40, 28, 0.25) !important;
    }

    .form-control[name="rccm"].is-invalid {
        border-color: #e0e0e0 !important;
        box-shadow: none !important;
    }

    /* Messages d'erreur personnalisés et améliorés */
    .custom-error-message {
        margin-top: 15px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #fff5f5, #fed7d7);
        border: 2px solid #f56565;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(245, 101, 101, 0.15);
        animation: errorShake 0.6s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .custom-error-message::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #f56565, #e53e3e, #f56565);
        animation: errorGlow 2s ease-in-out infinite;
    }

    .custom-error-message .error-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .custom-error-message .error-icon {
        color: #e53e3e;
        font-size: 1.5rem;
        animation: errorPulse 2s ease-in-out infinite;
        flex-shrink: 0;
    }

    .custom-error-message .error-text {
        flex: 1;
    }

    .custom-error-message .error-text strong {
        display: block;
        color: #c53030;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-error-message .error-text span {
        color: #742a2a;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.4;
    }

    /* Animations pour les messages d'erreur */
    @keyframes errorShake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    @keyframes errorGlow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    @keyframes errorPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Hover effect pour les messages d'erreur */
    .custom-error-message:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 101, 101, 0.25);
        border-color: #e53e3e;
    }

    /* Responsive pour les messages d'erreur */
    @media (max-width: 768px) {
        .custom-error-message {
            padding: 14px 16px;
        }

        .custom-error-message .error-content {
            gap: 12px;
        }

        .custom-error-message .error-icon {
            font-size: 1.3rem;
        }

        .custom-error-message .error-text strong {
            font-size: 1rem;
        }

        .custom-error-message .error-text span {
            font-size: 0.95rem;
        }
    }

    .custom-success-message {
        background-color: #dff0d8;
        border-color: #d6e9c6;
        color: #3c763d;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .success-content {
        display: flex;
        align-items: center;
    }

    .success-icon {
        font-size: 1.5rem;
        margin-right: 10px;
    }

    .success-text {
        flex: 1;
    }

    .close-success {
        background: none;
        border: none;
        color: #3c763d;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .custom-error-message {
        background-color: #f2dede;
        border-color: #ebccd1;
        color: #a94442;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .error-content {
        display: flex;
        align-items: center;
    }

    .error-icon {
        font-size: 1.5rem;
        margin-right: 10px;
    }

    .error-text {
        flex: 1;
    }

    .close-error {
        background: none;
        border: none;
        color: #a94442;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .form-control[name="rccm"].is-invalid {
        border-color: #e0e0e0 !important;
        box-shadow: none !important;
    }

    /* Messages de succès personnalisés avec le style COCEC */
    .custom-success-message {
        margin: 20px 0;
        padding: 20px 25px;
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border: 2px solid #28a745;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.15);
        animation: successSlideIn 0.6s ease-out;
        position: relative;
        overflow: hidden;
    }

    .custom-success-message::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #28a745, #20c997, #28a745);
        animation: successGlow 2s ease-in-out infinite;
    }

    .custom-success-message .success-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .custom-success-message .success-icon {
        color: #28a745;
        font-size: 1.8rem;
        animation: successPulse 2s ease-in-out infinite;
        flex-shrink: 0;
    }

    .custom-success-message .success-text {
        flex: 1;
    }

    .custom-success-message .success-text strong {
        display: block;
        color: #155724;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-success-message .success-text span {
        color: #155724;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.5;
    }

    .custom-success-message .close-success {
        background: #28a745;
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .custom-success-message .close-success:hover {
        background: #218838;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }

    /* Animations pour les messages de succès */
    @keyframes successSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes successGlow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    @keyframes successPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Hover effect pour les messages de succès */
    .custom-success-message:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.25);
        border-color: #20c997;
    }

    /* Responsive pour les messages de succès */
    @media (max-width: 768px) {
        .custom-success-message {
            padding: 16px 20px;
        }

        .custom-success-message .success-content {
            gap: 12px;
        }

        .custom-success-message .success-icon {
            font-size: 1.5rem;
        }

        .custom-success-message .success-text strong {
            font-size: 1.1rem;
        }

        .custom-success-message .success-text span {
            font-size: 0.95rem;
        }
    }

    /* Styles pour le champ RCCM optionnel */
    .form-control[data-optional="true"] {
        border-color: #ced4da;
    }

    .form-control[data-optional="true"]:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* S'assurer que les messages d'erreur sont bien visibles en rouge */
    .invalid-feedback {
        color: #dc3545 !important;
        font-weight: 500;
    }

    .form-control.is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
</style>
@endsection

@section('content')
<section class="account-form-section">
    @include('includes.main.loading')
    @include('includes.main.header')

    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <br>
                <h1 class="title-pro">Compte en Ligne - Personne Morale</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Compte en Ligne</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <br><br>

    <div class="container">
        <div class="form-container">
            <div class="section-heading mb-4 text-center">
                <h4 class="sub-heading"><span class="left-shape"></span>Compte en Ligne</h4>
                <h2 class="section-title">Ouvrez Votre Compte Professionnel COCEC</h2>
                <p>Rejoignez la COCEC en remplissant le formulaire ci-dessous. C'est simple, rapide et sécurisé.</p>
            </div>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <p class="mb-0"><strong>Oups !</strong> Veuillez corriger les erreurs indiquées en rouge ci-dessous avant de continuer.</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- FORMULAIRE PERSONNE MORALE -->
            <form action="{{ route('account.store.moral') }}" method="POST" enctype="multipart/form-data" class="adhesion-form multi-step-form" id="morale" novalidate>
                @csrf
                
                {{-- Champs honeypot pour détecter les bots --}}
                @include('components.honeypot')

                <div class="form-stepper">
                    <div class="step active" data-step="1">
                        <div class="step-icon">1</div>
                        <div class="step-label">Entité</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-icon">2</div>
                        <div class="step-label">Dirigeant & Contacts</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-icon">3</div>
                        <div class="step-label">Co-dirigeants & Signataires</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-icon">4</div>
                        <div class="step-label">Documents & Bénéficiaires</div>
                    </div>
                    <div class="step" data-step="5">
                        <div class="step-icon">5</div>
                        <div class="step-label">Versements & Consentement UMOA</div>
                    </div>
                    <div class="progress-line"></div>
                </div>

                <!-- Étape 1: Entité -->
                <div class="form-step-content active" data-step="1">
                    <h4 class="form-section-title">Informations sur l'Entité</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Dénomination / Raison Sociale</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required>
                            <div class="invalid-feedback">@error('company_name') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Catégorie</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}">
                            <div class="invalid-feedback">@error('category') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">N° RCCM / Récépissé <span class="text-muted">(optionnel)</span></label>
                            <input type="text" class="form-control @error('rccm') is-invalid @enderror" name="rccm" value="{{ old('rccm') }}" data-optional="true">
                            <div class="invalid-feedback">Ce champ est optionnel.</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Type de pièce d'identification</label>

                            <select class="form-control @error('company_id_type') is-invalid @enderror" name="company_id_type" required>
                                <option value="">Sélectionner...</option>
                                <option value="CNI" {{ old('company_id_type') == 'CNI' ? 'selected' : '' }}>Carte Nationale d'Identité</option>
                                <option value="Passeport" {{ old('company_id_type') == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                                <option value="Carte de Résident" {{ old('company_id_type') == 'Carte de Résident' ? 'selected' : '' }}>Carte de Résident</option>
                            </select>
                            <div class="invalid-feedback">@error('company_id_type') {{ $message }} @else Ce champ est requis. @enderror</div>





                            {{-- <input type="text" class="form-control @error('company_id_type') is-invalid @enderror" name="company_id_type" value="{{ old('company_id_type') }}"> --}}
                            <div class="invalid-feedback">@error('company_id_type') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Numéro de pièce</label>
                            <input type="text" class="form-control @error('company_id_number') is-invalid @enderror" name="company_id_number" value="{{ old('company_id_number') }}">
                            <div class="invalid-feedback">@error('company_id_number') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Date d'enregistrement</label>
                            <input type="date" class="form-control @error('company_id_date') is-invalid @enderror" name="company_id_date" value="{{ old('company_id_date') }}">
                            <div class="invalid-feedback">@error('company_id_date') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Date de création</label>
                            <input type="date" class="form-control @error('creation_date') is-invalid @enderror" name="creation_date" value="{{ old('creation_date') }}" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                            <div class="invalid-feedback">@error('creation_date') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Lieu de création</label>
                            <input type="text" class="form-control @error('creation_place') is-invalid @enderror" name="creation_place" value="{{ old('creation_place') }}" required>
                            <div class="invalid-feedback">@error('creation_place') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Secteur d'activité</label>
                            <input type="text" class="form-control @error('activity_sector') is-invalid @enderror" name="activity_sector" value="{{ old('activity_sector') }}" required>
                            <div class="invalid-feedback">@error('activity_sector') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Description de l'activité</label>
                            <textarea class="form-control @error('activity_description') is-invalid @enderror" name="activity_description" rows="4">{{ old('activity_description') }}</textarea>
                            <div class="invalid-feedback">@error('activity_description') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nationalité de l'entreprise</label>
                            <input type="text" class="form-control @error('company_nationality') is-invalid @enderror" name="company_nationality" value="{{ old('company_nationality') }}" required>
                            <div class="invalid-feedback">@error('company_nationality') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" value="{{ old('company_phone') }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                            <div class="invalid-feedback">@error('company_phone') {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Boîte postale</label>
                            <input type="text" class="form-control @error('company_postal_box') is-invalid @enderror" name="company_postal_box" value="{{ old('company_postal_box') }}">
                            <div class="invalid-feedback">@error('company_postal_box') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Ville</label>
                            <input type="text" class="form-control @error('company_city') is-invalid @enderror" name="company_city" value="{{ old('company_city') }}">
                            <div class="invalid-feedback">@error('company_city') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Quartier</label>
                            <input type="text" class="form-control @error('company_neighborhood') is-invalid @enderror" name="company_neighborhood" value="{{ old('company_neighborhood') }}">
                            <div class="invalid-feedback">@error('company_neighborhood') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                    </div>
                    <h4 class="form-section-title">Adresse de l'Entité</h4>
                    <div class="row mb-3 choice-container @error('loc_method_company') is-invalid @enderror">
                        <div class="col-6">
                            <input type="radio" name="loc_method_company" id="desc_company" value="description" {{ old('loc_method_company', 'description') == 'description' ? 'checked' : '' }} required>
                            <label for="desc_company" class="choice-label"><i class="fas fa-keyboard"></i> Décrire l'adresse</label>
                        </div>
                        <div class="col-6">
                            <input type="radio" name="loc_method_company" id="map_company" value="map" {{ old('loc_method_company') == 'map' ? 'checked' : '' }}>
                            <label for="map_company" class="choice-label"><i class="fas fa-map-marked-alt"></i> Sélectionner sur une carte</label>
                        </div>
                        <div class="invalid-feedback">@error('loc_method_company') {{ $message }} @else Veuillez choisir une méthode. @enderror</div>
                    </div>
                    <div class="method-area" id="description-area-company">
                        <div class="input-group-custom">
                            <label class="form-label">Description détaillée de l'adresse</label>
                            <textarea class="form-control @error('company_address') is-invalid @enderror" name="company_address" rows="4" placeholder="Indiquer ville, quartier, rue, repères..." required>{{ old('company_address') }}</textarea>
                            <div class="invalid-feedback">@error('company_address') {{ $message }} @else Ce champ est requis si vous choisissez de décrire l'adresse. @enderror</div>
                        </div>
                    </div>
                    <div class="method-area" id="map-area-company">
                        <label class="form-label">Cliquez sur la carte ou déplacez le marqueur pour indiquer l'adresse de l'entité</label>
                        <div id="map-container-company" class="map-container"></div>
                        <input type="hidden" name="company_lat" id="latitude-company" value="{{ old('company_lat') }}" required>
                        <input type="hidden" name="company_lng" id="longitude-company" value="{{ old('company_lng') }}" required>
                        <div class="invalid-feedback">@error('company_lat') Une position sur la carte est requise. @else Veuillez sélectionner un point sur la carte. @enderror</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Schéma/Plan</label>
                        <div class="file-upload-wrapper @error('company_plan_path') is-invalid @enderror">
                            <div class="file-upload-content">
                                <i class="fas fa-file-image file-upload-icon"></i>
                                <p class="file-upload-text">Importer un schéma/plan (JPEG, PNG, JPG, PDF)</p>
                            </div>
                            <div class="file-upload-preview"></div>
                            <input type="file" name="company_plan_path" accept="image/jpeg,image/png,image/jpg,application/pdf">
                            <div class="invalid-feedback">@error('company_plan_path') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                    </div>
                    
                    <!-- Champs PPE -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label class="form-label">Personne politiquement exposée (nationale) ?</label>
                                <select class="form-control" name="is_ppe_national" id="is_ppe_national">
                                    <option value="0" {{ old('is_ppe_national', '0') == '0' ? 'selected' : '' }}>Non</option>
                                    <option value="1" {{ old('is_ppe_national') == '1' ? 'selected' : '' }}>Oui</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label class="form-label">Personne politiquement exposée (étranger) ?</label>
                                <select class="form-control" name="ppe_foreign" id="ppe_foreign">
                                    <option value="0" {{ old('ppe_foreign', '0') == '0' ? 'selected' : '' }}>Non</option>
                                    <option value="1" {{ old('ppe_foreign') == '1' ? 'selected' : '' }}>Oui</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 2: Dirigeant & Contacts -->
                <div class="form-step-content" data-step="2">
                    <h4 class="form-section-title">Informations sur le Dirigeant</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control @error('director_name') is-invalid @enderror" name="director_name" value="{{ old('director_name') }}" required>
                            <div class="invalid-feedback">@error('director_name') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Prénoms</label>
                            <input type="text" class="form-control @error('director_first_name') is-invalid @enderror" name="director_first_name" value="{{ old('director_first_name') }}">
                            <div class="invalid-feedback">@error('director_first_name') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Poste</label>
                            <input type="text" class="form-control @error('director_position') is-invalid @enderror" name="director_position" value="{{ old('director_position') }}" required>
                            <div class="invalid-feedback">@error('director_position') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Sexe</label>
                            <select class="form-control @error('director_gender') is-invalid @enderror" name="director_gender" required>
                                <option value="">Sélectionner...</option>
                                <option value="M" {{ old('director_gender') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('director_gender') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            <div class="invalid-feedback">@error('director_gender') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nationalité</label>
                            <input type="text" class="form-control @error('director_nationality') is-invalid @enderror" name="director_nationality" value="{{ old('director_nationality') }}" required>
                            <div class="invalid-feedback">@error('director_nationality') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Date de Naissance</label>
                            <input type="date" class="form-control @error('director_birth_date') is-invalid @enderror" name="director_birth_date" value="{{ old('director_birth_date') }}" max="{{ \Carbon\Carbon::today()->subYears(18)->format('Y-m-d') }}" required>
                            <div class="invalid-feedback">@error('director_birth_date') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Lieu de Naissance</label>
                            <input type="text" class="form-control @error('director_birth_place') is-invalid @enderror" name="director_birth_place" value="{{ old('director_birth_place') }}" required>
                            <div class="invalid-feedback">@error('director_birth_place') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Numéro de pièce d'identité</label>
                            <input type="text" class="form-control @error('director_id_number') is-invalid @enderror" name="director_id_number" value="{{ old('director_id_number') }}" required>
                            <div class="invalid-feedback">@error('director_id_number') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Date d'émission de la pièce</label>
                            <input type="date" class="form-control @error('director_id_issue_date') is-invalid @enderror" name="director_id_issue_date" value="{{ old('director_id_issue_date') }}">
                            <div class="invalid-feedback">@error('director_id_issue_date') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('director_phone') is-invalid @enderror" name="director_phone" value="{{ old('director_phone') }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                            <div class="invalid-feedback">@error('director_phone') {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom du père</label>
                            <input type="text" class="form-control @error('director_father_name') is-invalid @enderror" name="director_father_name" value="{{ old('director_father_name') }}">
                            <div class="invalid-feedback">@error('director_father_name') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom de la mère</label>
                            <input type="text" class="form-control @error('director_mother_name') is-invalid @enderror" name="director_mother_name" value="{{ old('director_mother_name') }}">
                            <div class="invalid-feedback">@error('director_mother_name') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Boîte postale</label>
                            <input type="text" class="form-control @error('director_postal_box') is-invalid @enderror" name="director_postal_box" value="{{ old('director_postal_box') }}">
                            <div class="invalid-feedback">@error('director_postal_box') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Ville</label>
                            <input type="text" class="form-control @error('director_city') is-invalid @enderror" name="director_city" value="{{ old('director_city') }}">
                            <div class="invalid-feedback">@error('director_city') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Quartier</label>
                            <input type="text" class="form-control @error('director_neighborhood') is-invalid @enderror" name="director_neighborhood" value="{{ old('director_neighborhood') }}">
                            <div class="invalid-feedback">@error('director_neighborhood') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Adresse</label>
                            <textarea class="form-control @error('director_address') is-invalid @enderror" name="director_address" rows="4">{{ old('director_address') }}</textarea>
                            <div class="invalid-feedback">@error('director_address') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom du/de la conjoint(e)</label>
                            <input type="text" class="form-control @error('director_spouse_name') is-invalid @enderror" name="director_spouse_name" value="{{ old('director_spouse_name') }}">
                            <div class="invalid-feedback">@error('director_spouse_name') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Profession du/de la conjoint(e)</label>
                            <input type="text" class="form-control @error('director_spouse_occupation') is-invalid @enderror" name="director_spouse_occupation" value="{{ old('director_spouse_occupation') }}">
                            <div class="invalid-feedback">@error('director_spouse_occupation') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Téléphone du/de la conjoint(e)</label>
                            <input type="tel" class="form-control @error('director_spouse_phone') is-invalid @enderror" name="director_spouse_phone" value="{{ old('director_spouse_phone') }}" pattern="\+?[0-9\s\-\(\)]{7,15}">
                            <div class="invalid-feedback">@error('director_spouse_phone') {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Adresse du/de la conjoint(e)</label>
                            <textarea class="form-control @error('director_spouse_address') is-invalid @enderror" name="director_spouse_address" rows="4">{{ old('director_spouse_address') }}</textarea>
                            <div class="invalid-feedback">@error('director_spouse_address') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                    </div>
                    <h4 class="form-section-title">Procès-verbaux</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Membres du procès-verbal</label>
                            <input type="text" class="form-control @error('minutes_members') is-invalid @enderror" name="minutes_members" value="{{ old('minutes_members') }}" required>
                            <div class="invalid-feedback">@error('minutes_members') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Réunion du procès-verbal</label>
                            <input type="text" class="form-control @error('minutes_meeting') is-invalid @enderror" name="minutes_meeting" value="{{ old('minutes_meeting') }}" required>
                            <div class="invalid-feedback">@error('minutes_meeting') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                    </div>
                    <h4 class="form-section-title">Contact d'Urgence</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom & Prénoms</label>
                            <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required>
                            <div class="invalid-feedback">@error('emergency_contact_name') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('emergency_contact_phone') is-invalid @enderror" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                            <div class="invalid-feedback">@error('emergency_contact_phone') {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                        </div>
                        <div class="col-md-12 mb-3 input-group-custom">
                            <label class="form-label">Adresse</label>
                            <textarea class="form-control @error('emergency_contact_address') is-invalid @enderror" name="emergency_contact_address" rows="4">{{ old('emergency_contact_address') }}</textarea>
                            <div class="invalid-feedback">@error('emergency_contact_address') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                    </div>
                </div>

                <!-- Étape 3: Co-dirigeants & Signataires -->
                <div class="form-step-content" data-step="3">
                    <h4 class="form-section-title">Co-dirigeants</h4>
                    <div id="co-directors-container"></div>
                    <button type="button" class="btn btn-outline-primary mt-2 dynamic-adder-btn" data-container="co-directors-container" data-type="co_director"><i class="fas fa-plus"></i> Ajouter un co-dirigeant</button>

                    <h4 class="form-section-title">Signataires du Compte</h4>
                    <div id="account-signatories-container">
                        <!-- Signataire 1 (par défaut) -->
                        <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                            <h5>Signataire 1</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="account_signatories[0][name]" required>
                                    <div class="invalid-feedback">Ce champ est requis.</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Type de signature</label>
                                    <select class="form-control" name="account_signatories[0][signature_type]" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="unique">Unique</option>
                                        <option value="conjointe">Conjointe</option>
                                    </select>
                                    <div class="invalid-feedback">Ce champ est requis.</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Numéro de pièce d'identité</label>
                                    <input type="text" class="form-control" name="account_signatories[0][id_number]">
                                    <div class="invalid-feedback">Ce champ est optionnel.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Signataire 2 (par défaut) -->
                        <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                            <h5>Signataire 2</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="account_signatories[1][name]" required>
                                    <div class="invalid-feedback">Ce champ est requis.</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Type de signature</label>
                                    <select class="form-control" name="account_signatories[1][signature_type]" required>
                                        <option value="">Sélectionner...</option>
                                        <option value="unique">Unique</option>
                                        <option value="conjointe">Conjointe</option>
                                    </select>
                                    <div class="invalid-feedback">Ce champ est requis.</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Numéro de pièce d'identité</label>
                                    <input type="text" class="form-control" name="account_signatories[1][id_number]">
                                    <div class="invalid-feedback">Ce champ est optionnel.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-2 dynamic-adder-btn" data-container="account-signatories-container" data-type="account_signatory"><i class="fas fa-plus"></i> Ajouter un signataire</button>
                    <div id="account-signatories-error" class="custom-error-message" style="display: none;">
                        <div class="error-content">
                            <i class="fas fa-exclamation-triangle error-icon"></i>
                            <div class="error-text">
                                <strong>Attention !</strong>
                                <span>Veuillez remplir les informations des deux signataires obligatoires.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 4: Documents & Bénéficiaires -->
                <div class="form-step-content" data-step="4">
                    <h4 class="form-section-title">Documents Juridiques</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Document de l'entreprise</label>
                            <div class="file-upload-wrapper @error('company_document_path') is-invalid @enderror">
                                <div class="file-upload-content">
                                    <i class="fas fa-file-pdf file-upload-icon"></i>
                                    <p class="file-upload-text">Importer le document (PDF)</p>
                                </div>
                                <div class="file-upload-preview"></div>
                                <input type="file" name="company_document_path" accept="application/pdf" required>
                                <div class="invalid-feedback">@error('company_document_path') {{ $message }} @else Le document est requis (PDF). @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Photo des responsables</label>
                            <div class="file-upload-wrapper @error('responsible_persons_photo_path') is-invalid @enderror">
                                <div class="file-upload-content">
                                    <i class="fas fa-camera file-upload-icon"></i>
                                    <p class="file-upload-text">Choisir une photo (JPEG, PNG, JPG)</p>
                                </div>
                                <div class="file-upload-preview"></div>
                                <input type="file" name="responsible_persons_photo_path" id="responsible-photo-input" accept="image/jpeg,image/png,image/jpg" required>
                                <div class="invalid-feedback">@error('responsible_persons_photo_path') {{ $message }} @else Une photo est requise. @enderror</div>
                            </div>
                        </div>
                    </div>
                    <!-- Signature supprimée de l'étape 4 - Déplacée à l'étape 5 -->
                    <h4 class="form-section-title">Bénéficiaires</h4>
                    
                    <div id="beneficiaries-container">
                        <!-- Bénéficiaire 1 (par défaut) -->
                        <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                            <h5>Bénéficiaire 1</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Nom & Prénoms</label>
                                    <input type="text" class="form-control" name="beneficiaries[0][nom]" required>
                                    <div class="invalid-feedback">Ce champ est requis.</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Contact</label>
                                    <input type="tel" class="form-control" name="beneficiaries[0][contact]" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                    <div class="invalid-feedback">Numéro de téléphone invalide.</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Lien / Relation</label>
                                    <input type="text" class="form-control" name="beneficiaries[0][lien]" required>
                                    <div class="invalid-feedback">Ce champ est requis.</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control" name="beneficiaries[0][birth_date]">
                                    <div class="invalid-feedback">Ce champ est optionnel.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-2 dynamic-adder-btn" data-container="beneficiaries-container" data-type="beneficiary"><i class="fas fa-plus"></i> Ajouter un bénéficiaire</button>
                    <br>
                    <br>
                    <!-- Section bénéficiaires supprimée - Déplacée plus haut dans l'étape 4 -->
                </div>

                <!-- Étape 5: Versements + Consentement UMOA + Signature -->
                <div class="form-step-content" data-step="5">
                    <!-- Section Versements -->
                    <h4 class="form-section-title">Versements Initiaux</h4>
                    <div class="row align-items-center mb-5">
                        <div class="col-md-6">
                            <div class="input-group-custom mb-3">
                                <label class="form-label">Dépôt Initial (FCFA)</label>
                                <input type="number" class="form-control @error('initial_deposit') is-invalid @enderror" id="depot-initial-morale" name="initial_deposit" value="{{ old('initial_deposit', 0) }}" min="0" step="1000" required>
                                <div class="invalid-feedback">@error('initial_deposit') {{ $message }} @else Ce champ est requis. @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="versements-summary">
                                <div class="row-item"><span class="label">Droit d'adhésion</span> <span class="value">2,000 FCFA</span></div>
                                <div class="row-item"><span class="label">Part Sociale</span> <span class="value">15,000 FCFA</span></div>
                                <div class="row-item total-row"><span class="total-label">TOTAL À VERSER</span> <span class="total-value" id="total-versement-morale">17,000 FCFA</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Consentement UMOA -->
                    <h4 class="form-section-title">Consentement UMOA - Personne Morale</h4>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="consent-form-header text-center">
                                <h5 class="mb-3"><strong>FORMULAIRE TYPE D'OBTENTION DU CONSENTEMENT DANS LE CADRE DU SYSTEME DE PARTAGE D'INFORMATION SUR LE CREDIT DANS L'UMOA</strong></h5>
                                <h6 class="mb-4"><strong>[PERSONNE MORALE]</strong></h6>
                            </div>
                        </div>
                        
                        <!-- Checkboxes de consentement -->
                        <div class="col-12 mb-4">
                            <div class="consent-checkboxes">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent1-morale" required>
                                    <label class="form-check-label" for="consent1-morale">
                                        <strong>Accepte que les informations de crédit, historiques et courantes, me concernant notamment, les soldes approuvés et en souffrance, les limites de crédit, les cessations de paiement, le solde des arriérés auprès de la COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT (COCEC) soient transmises à CREDIT INFO VOLO COTE D'IVOIRE, Rue Des Jardins, Cocody, 2 Plateaux 01 BP 11266 Abidjan 01 - Côte d'Ivoire.</strong> <em>[Art 41 points 2, 3 et 4, Art 44, points 1 et 2]</em>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent2-morale" required>
                                    <label class="form-check-label" for="consent2-morale">
                                        <strong>Accepte que les informations précitées soient communiquées par CREDIT INFO VOLO COTE D'IVOIRE aux établissements ayant accès à sa base de données, y compris ceux situés sur le territoire d'un autre Etat membre de l'UMOA.</strong> <em>[Art 42 point 1, Art 44, point 4]</em>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent3-morale" required>
                                    <label class="form-check-label" for="consent3-morale">
                                        <strong>Comprends que ces informations ne peuvent, en aucun cas, porter sur mes dépôts</strong> <em>[Art 53, alinéa 3]</em>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent4-morale" required>
                                    <label class="form-check-label" for="consent4-morale">
                                        <strong>Comprends que CREDIT INFO VOLO COTE D'IVOIRE ne diffusera que les informations dont l'ancienneté n'excède pas cinq (5) ans.</strong> <em>[Art 41, point 3]</em>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent5-morale" required>
                                    <label class="form-check-label" for="consent5-morale">
                                        <strong>Comprends que CREDIT INFO VOLO COTE D'IVOIRE conservera ces informations pendant une durée de cinq (5) ans supplémentaire après la cession de la relation d'affaires avec la COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT (COCEC).</strong> <em>[Art 41, point 4]</em>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent6-morale" required>
                                    <label class="form-check-label" for="consent6-morale">
                                        <strong>Comprends que j'ai le droit d'accès aux données me concernant dans la base de données CREDIT INFO VOLO COTE D'IVOIRE afin de vérifier mes historiques de crédit, de contester et faire corriger ou radier des informations erronées dans ladite base ou dans un rapport de crédit.</strong> <em>[Art 44, point 7]</em>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent7-morale" required>
                                    <label class="form-check-label" for="consent7-morale">
                                        <strong>Comprends que j'ai le droit de recevoir toutes les informations conservées par CREDIT INFO VOLO COTE D'IVOIRE sur mon historique de crédit, sous la forme d'un rapport de crédit gratuitement une (1) fois par an et en cas de litige lié à une erreur dans les données, imputable à la COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT (COCEC) ou à CREDIT INFO VOLO COTE D'IVOIRE.</strong> <em>[Art 44, point 8]</em>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="alert alert-info">
                                <strong>Références de la Loi uniforme portant réglementation des BIC</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Section Signature Unique -->
                    <h4 class="form-section-title mt-5">Signature de l'Adhésion</h4>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Information importante :</strong> Cette signature sera prise en compte pour l'ensemble de votre adhésion et les autres questionnaires de cette procédure.
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="row choice-container @error('signature_method') is-invalid @enderror">
                                <div class="col-6">
                                    <input type="radio" name="signature_method" id="draw_morale" value="draw" {{ old('signature_method', 'draw') == 'draw' ? 'checked' : '' }} required>
                                    <label for="draw_morale" class="choice-label"><i class="fas fa-pencil-alt"></i> Dessiner</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" name="signature_method" id="upload_morale" value="upload" {{ old('signature_method') == 'upload' ? 'checked' : '' }}>
                                    <label for="upload_morale" class="choice-label"><i class="fas fa-upload"></i> Importer</label>
                                </div>
                                <div class="invalid-feedback" id="signature-method-error">@error('signature_method') {{ $message }} @else Une méthode de signature est requise. @enderror</div>
                            </div>

                            <div class="method-area" id="draw-area-morale">
                                <p class="text-muted small">Signez dans le cadre ci-dessous.</p>
                                <canvas id="signature-pad-morale" width="600" height="200"></canvas>
                                <div class="signature-controls">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="clear-signature-btn-morale-final">
                                        <i class="fas fa-eraser me-2"></i>Effacer
                                    </button>
                                </div>
                                <input type="hidden" name="signature_data" id="signature-data-morale" value="{{ old('signature_data') }}">
                                <div id="signature-draw-error-morale" class="custom-error-message" style="display:none;">
                                    <div class="error-content">
                                        <i class="fas fa-exclamation-triangle error-icon"></i>
                                        <div class="error-text">
                                            <strong>Attention !</strong>
                                            <span>Veuillez dessiner une signature.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="method-area" id="upload-area-morale">
                                <div class="@error('signature_upload') is-invalid @enderror file-upload-wrapper">
                                    <div class="file-upload-content">
                                        <i class="fas fa-file-image file-upload-icon"></i>
                                        <p class="file-upload-text">Importer (PNG)</p>
                                    </div>
                                    <div class="file-upload-preview"></div>
                                    <input type="file" name="signature_upload" accept="image/png" />
                                    <div class="invalid-feedback">@error('signature_upload') {{ $message }} @else L'import de la signature est requis. @enderror</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                {{-- Widget reCAPTCHA --}}
                <div class="mt-4 text-center" style="display: none;" id="recaptcha-container">
                    @include('components.recaptcha', ['action' => 'account_creation'])
                </div>

                <div class="form-navigation-buttons">
                    <button type="button" class="btn btn-nav btn-prev" style="display: none;">Précédent</button>
                    <button type="button" class="btn btn-nav btn-next" style="margin-left: auto;">Suivant</button>
                    <button type="submit" class="btn btn-submit-form btn-next" style="display: none;" id="submit-btn-morale">
                        <i class="fas fa-check-circle"></i> Soumettre l'adhésion
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <br><br><br>

    @include('includes.main.scroll')
    @include('includes.main.footer')
</section>
@endsection


@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.multi-step-form');
        forms.forEach((form, formIndex) => {
            const steps = form.querySelectorAll('.form-step-content');
            const stepperItems = form.querySelectorAll('.form-stepper .step');
            const progressLine = form.querySelector('.form-stepper .progress-line');
            const prevBtn = form.querySelector('.btn-prev');
            const nextBtn = form.querySelector('.btn-next');
            const submitBtn = form.querySelector('.btn-submit-form');
            let currentStep = 1;
            const maps = new Map();

            function updateProgress() {
                const progress = (currentStep / steps.length) * 100;
                progressLine.style.width = `${progress}%`;
                stepperItems.forEach((item, index) => {
                    item.classList.toggle('active', index + 1 <= currentStep);
                    if (index + 1 < currentStep) {
                        item.classList.add('completed');
                    } else {
                        item.classList.remove('completed');
                    }
                });
            }

            function showStep(step) {
                steps.forEach(s => s.classList.remove('active'));
                steps[step - 1].classList.add('active');
                prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
                nextBtn.style.display = step === steps.length ? 'none' : 'inline-block';
                submitBtn.style.display = step === steps.length ? 'inline-block' : 'none';
                updateProgress();

                // Afficher/masquer reCAPTCHA selon l'étape
                const recaptchaContainer = document.getElementById('recaptcha-container');
                if (recaptchaContainer) {
                    if (step === steps.length) {
                        recaptchaContainer.style.display = 'block';
                    } else {
                        recaptchaContainer.style.display = 'none';
                    }
                }

                const mapContainer = steps[step - 1].querySelector('.map-container');
                if (mapContainer) {
                    const mapObj = maps.get(mapContainer.id);
                    if (mapObj) {
                        setTimeout(() => mapObj.invalidate(), 100);
                    }
                }
            }

            function validateStep(step) {
                const currentStepContent = steps[step - 1];
                let isValid = true;

                form.classList.add('was-validated'); // Active bootstrap validation styles

                const requiredInputs = currentStepContent.querySelectorAll('input[required], select[required], textarea[required]');
                requiredInputs.forEach(input => {
                    if (input.name.includes('signature')) return;

                    if (!input.checkValidity()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                // Validation spécifique pour les champs dynamiques
                if (step === 3) { // Signataires
                    const container = currentStepContent.querySelector('#account-signatories-container');
                    const errorElement = document.getElementById('account-signatories-error');
                    if (container && errorElement) {
                    if (container.children.length < 2) {
                        errorElement.style.display = 'block';
                        isValid = false;
                    } else {
                        errorElement.style.display = 'none';
                        }
                    }
                }
                if (step === 4) { // Bénéficiaires
                    const container = currentStepContent.querySelector('#beneficiaries-container');
                    const errorElement = document.getElementById('beneficiaries-error');
                    if (container && errorElement) {
                    if (container.children.length < 1) {
                        errorElement.style.display = 'block';
                        isValid = false;
                    } else {
                        errorElement.style.display = 'none';
                        }
                    }
                }

                // Validation de la méthode de localisation
                if (step === 1) {
                    const locMethod = currentStepContent.querySelector('input[name="loc_method_company"]:checked');
                    const choiceContainer = currentStepContent.querySelector('input[name="loc_method_company"]').closest('.choice-container');
                    if (!locMethod) {
                        choiceContainer.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        choiceContainer.classList.remove('is-invalid');
                    }
                }

                // Validation pour l'étape UMOA (étape 5)
                if (step === 5) {
                    // Vérifier que tous les checkboxes sont cochés
                    const checkboxes = currentStepContent.querySelectorAll('input[type="checkbox"]');
                    let uncheckedCount = 0;

                    checkboxes.forEach((checkbox, index) => {
                        if (!checkbox.checked) {
                            checkbox.classList.add('is-invalid');
                            // Ajouter un message d'erreur sous chaque checkbox non coché
                            let errorDiv = checkbox.parentNode.querySelector('.umoa-checkbox-error');
                            if (!errorDiv) {
                                errorDiv = document.createElement('div');
                                errorDiv.className = 'umoa-checkbox-error invalid-feedback';
                                errorDiv.style.display = 'block';
                                errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Ce consentement est obligatoire pour continuer.';
                                checkbox.parentNode.appendChild(errorDiv);
                            }
                            uncheckedCount++;
                            isValid = false;
                        } else {
                            checkbox.classList.remove('is-invalid');
                            // Supprimer le message d'erreur si le checkbox est coché
                            const errorDiv = checkbox.parentNode.querySelector('.umoa-checkbox-error');
                            if (errorDiv) {
                                errorDiv.remove();
                            }
                        }
                    });

                    // Afficher un message d'erreur général si des checkboxes ne sont pas cochés
                    let generalError = currentStepContent.querySelector('.umoa-general-error');
                    if (uncheckedCount > 0) {
                        if (!generalError) {
                            generalError = document.createElement('div');
                            generalError.className = 'umoa-general-error alert alert-danger mt-3';
                            generalError.innerHTML = `
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Attention :</strong> Vous devez accepter tous les consentements UMOA pour continuer. 
                                <span class="badge bg-danger ms-2">${uncheckedCount} consentement(s) manquant(s)</span>
                            `;
                            currentStepContent.querySelector('.consent-checkboxes').after(generalError);
                        }
                    } else {
                        if (generalError) {
                            generalError.remove();
                        }
                    }

                    // Validation de la signature (seulement si les éléments existent)
                    const signatureMethod = currentStepContent.querySelector('input[name="signature_method"]:checked');
                    if (signatureMethod) {
                        if (signatureMethod.value === 'draw') {
                            const canvas = currentStepContent.querySelector('#signature-pad-morale');
                            if (canvas && canvas.signaturePadInstance) {
                            const signaturePad = canvas.signaturePadInstance;
                                if (signaturePad.isEmpty()) {
                                    const errorElement = currentStepContent.querySelector('#signature-draw-error-morale');
                                    if (errorElement) errorElement.style.display = 'block';
                                isValid = false;
                            } else {
                                    const errorElement = currentStepContent.querySelector('#signature-draw-error-morale');
                                    if (errorElement) errorElement.style.display = 'none';
                                }
                            }
                        } else if (signatureMethod.value === 'upload') {
                            const signatureUpload = currentStepContent.querySelector('input[name="signature_upload"]');
                            if (signatureUpload && !signatureUpload.files.length) {
                                const wrapper = signatureUpload.closest('.file-upload-wrapper');
                                if (wrapper) wrapper.classList.add('is-invalid');
                                isValid = false;
                            } else if (signatureUpload) {
                                const wrapper = signatureUpload.closest('.file-upload-wrapper');
                                if (wrapper) wrapper.classList.remove('is-invalid');
                            }
                        }
                    } else {
                        const choiceContainer = currentStepContent.querySelector('input[name="signature_method"]')?.closest('.choice-container');
                        if (choiceContainer) choiceContainer.classList.add('is-invalid');
                        isValid = false;
                    }

                    // Vérifier reCAPTCHA à la dernière étape
                    if (!window.isRecaptchaResolved()) {
                        isValid = false;
                        // Afficher un message d'erreur pour reCAPTCHA
                        let recaptchaError = document.querySelector('.recaptcha-error');
                        if (!recaptchaError) {
                            recaptchaError = document.createElement('div');
                            recaptchaError.className = 'recaptcha-error alert alert-warning mt-3';
                            recaptchaError.innerHTML = '<i class="fas fa-shield-alt me-2"></i>Veuillez cocher la case "Je ne suis pas un robot" pour continuer.';
                            document.getElementById('recaptcha-container').after(recaptchaError);
                        }
                    } else {
                        // Supprimer l'erreur reCAPTCHA si résolu
                        const recaptchaError = document.querySelector('.recaptcha-error');
                        if (recaptchaError) {
                            recaptchaError.remove();
                        }
                    }
                }

                if (!isValid) {
                    const firstInvalid = currentStepContent.querySelector('.is-invalid, .ng-invalid, :invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }

                return isValid;
            }

            prevBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            nextBtn.addEventListener('click', () => {
                if (validateStep(currentStep) && currentStep < steps.length) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            const depotInput = form.querySelector('#depot-initial-morale');
            const totalSpan = form.querySelector('#total-versement-morale');
            if (depotInput && totalSpan) {
                const baseAmount = 17000;
                depotInput.addEventListener('input', () => {
                    const depot = parseFloat(depotInput.value) || 0;
                    totalSpan.textContent = `${(baseAmount + depot).toLocaleString('fr-FR')} FCFA`;
                });
            }

            const dynamicButtons = form.querySelectorAll('.dynamic-adder-btn');
            console.log('Boutons dynamiques trouvés:', dynamicButtons.length);

            dynamicButtons.forEach((btn, btnIndex) => {
                console.log(`Attachement d'événement au bouton ${btnIndex + 1}:`, btn.dataset.type, btn.dataset.container);
                btn.addEventListener('click', () => {
                    console.log('Clic sur bouton dynamique:', btn.dataset.type, btn.dataset.container);
                    const containerId = btn.dataset.container;
                    const type = btn.dataset.type;
                    const container = document.getElementById(containerId);
                    console.log('Container trouvé:', container);
                    const index = container.querySelectorAll('.dynamic-field').length;
                    console.log('Index calculé:', index);
                    let template = '';

                    if (type === 'co_director') {
                        template = `
                            <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                                <h5>Co-dirigeant ${index + 1}</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Nom</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][name]" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Prénoms</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][first_name]">
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Sexe</label>
                                        <select class="form-control" name="co_directors[${index}][gender]" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="M">Masculin</option>
                                            <option value="F">Féminin</option>
                                        </select>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Nationalité</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][nationality]" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control" name="co_directors[${index}][birth_date]" max="{{ \Carbon\Carbon::today()->subYears(18)->format('Y-m-d') }}" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Lieu de naissance</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][birth_place]" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Numéro de pièce d'identité</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][id_number]" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Date d'émission de la pièce</label>
                                        <input type="date" class="form-control" name="co_directors[${index}][id_issue_date]">
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Boîte postale</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][postal_box]">
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Ville</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][city]">
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Quartier</label>
                                        <input type="text" class="form-control" name="co_directors[${index}][neighborhood]">
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Adresse</label>
                                        <textarea class="form-control" name="co_directors[${index}][address]" rows="4"></textarea>
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" name="co_directors[${index}][phone]" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                        <div class="invalid-feedback">Numéro de téléphone invalide.</div>
                                    </div>
                                </div>
                            </div>`;
                    } else if (type === 'account_signatory') {
                        template = `
                            <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                                <h5>Signataire ${index + 1}</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Nom</label>
                                        <input type="text" class="form-control" name="account_signatories[${index}][name]" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Type de signature</label>
                                        <select class="form-control" name="account_signatories[${index}][signature_type]" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="unique">Unique</option>
                                            <option value="conjointe">Conjointe</option>
                                        </select>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Numéro de pièce d'identité</label>
                                        <input type="text" class="form-control" name="account_signatories[${index}][id_number]">
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                </div>
                            </div>`;
                    } else if (type === 'beneficiary') {
                        template = `
                            <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                                <h5>Bénéficiaire ${index + 1}</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Nom & Prénoms</label>
                                        <input type="text" class="form-control" name="beneficiaries[${index}][nom]" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Contact</label>
                                        <input type="tel" class="form-control" name="beneficiaries[${index}][contact]" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                        <div class="invalid-feedback">Numéro de téléphone invalide.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Lien / Relation</label>
                                        <input type="text" class="form-control" name="beneficiaries[${index}][lien]" required>
                                        <div class="invalid-feedback">Ce champ est requis.</div>
                                    </div>
                                    <div class="col-md-6 mb-3 input-group-custom">
                                        <label class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control" name="beneficiaries[${index}][birth_date]">
                                        <div class="invalid-feedback">Ce champ est optionnel.</div>
                                    </div>
                                </div>
                            </div>`;
                    }
                    container.insertAdjacentHTML('beforeend', template);
                    container.querySelectorAll('.remove-field').forEach(removeBtn => {
                        removeBtn.addEventListener('click', () => {
                            removeBtn.closest('.dynamic-field').remove();
                            // Ne pas appeler validateStep ici pour éviter les erreurs
                        });
                    });
                });

                form.querySelectorAll('input[type="file"]').forEach(input => {
                    input.addEventListener('change', () => {
                        const wrapper = input.closest('.file-upload-wrapper');
                        const preview = wrapper.querySelector('.file-upload-preview');
                        const file = input.files[0];
                        if (file) {
                            preview.innerHTML = `<span>${file.name}</span>`;
                            wrapper.classList.remove('is-invalid');
                        } else {
                            preview.innerHTML = '';
                            wrapper.classList.toggle('is-invalid', input.hasAttribute('required'));
                        }
                    });
                });

                const locRadios = form.querySelectorAll('input[name="loc_method_company"]');
                locRadios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        const descArea = form.querySelector('#description-area-company');
                        const mapArea = form.querySelector('#map-area-company');
                        const descInput = descArea.querySelector('textarea[name="company_address"]');
                        const latInput = mapArea.querySelector('input[name="company_lat"]');
                        const lngInput = mapArea.querySelector('input[name="company_lng"]');

                        descArea.style.display = radio.value === 'description' ? 'block' : 'none';
                        mapArea.style.display = radio.value === 'map' ? 'block' : 'none';
                        descInput.toggleAttribute('required', radio.value === 'description');
                        latInput.toggleAttribute('required', radio.value === 'map');
                        lngInput.toggleAttribute('required', radio.value === 'map');

                        if (radio.value === 'map') {
                            const mapObj = maps.get('map-container-company');
                            if (mapObj) {
                                setTimeout(() => mapObj.invalidate(), 100);
                            }
                        }
                    });
                    if (radio.checked) radio.dispatchEvent(new Event('change'));
                });

                function initializeLeafletMap(mapId, latInputId, lonInputId) {
                    const mapContainer = document.getElementById(mapId);
                    if (!mapContainer) return null;

                    const latInput = document.getElementById(latInputId);
                    const lonInput = document.getElementById(lonInputId);
                    const fallbackCoords = [6.1375, 1.2226];
                    let map;
                    let marker;

                    const setupMap = (coords) => {
                        if (map) {
                            map.setView(coords, 14);
                            marker.setLatLng(coords);
                            updateInputs(coords);
                            return;
                        }

                        map = L.map(mapId).setView(coords, 14);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);

                        marker = L.marker(coords, {
                            draggable: true
                        }).addTo(map);
                        updateInputs(marker.getLatLng());

                        marker.on('dragend', (event) => updateInputs(event.target.getLatLng()));
                        map.on('click', (e) => {
                            marker.setLatLng(e.latlng);
                            updateInputs(e.latlng);
                        });
                    };

                    const updateInputs = (latlng) => {
                        latInput.value = latlng.lat.toFixed(6);
                        lonInput.value = latlng.lng.toFixed(6);
                    };

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => setupMap([position.coords.latitude, position.coords.longitude]),
                            () => setupMap(fallbackCoords)
                        );
                    } else {
                        setupMap(fallbackCoords);
                    }

                    return {
                        invalidate: () => {
                            if (map) map.invalidateSize();
                        }
                    };
                }

                maps.set('map-container-company', initializeLeafletMap('map-container-company', 'latitude-company', 'longitude-company'));

                // ==== FONCTIONS SIGNATURE CORRIGÉES ====
                function setupSignatureChoice() {
                    const radioButtons = form.querySelectorAll('input[name="signature_method"]');
                    if (!radioButtons.length) return;

                    const drawArea = form.querySelector('#draw-area-morale');
                    const uploadArea = form.querySelector('#upload-area-morale');
                    const canvas = form.querySelector('#signature-pad-morale');
                    const uploadInput = form.querySelector('input[name="signature_upload"]');
                    let signaturePadInstance = null;

                    function updateSignatureArea() {
                        const selectedValue = form.querySelector('input[name="signature_method"]:checked')?.value;
                        if (!selectedValue) return;

                        if (drawArea && uploadArea) {
                        drawArea.style.display = selectedValue === 'draw' ? 'block' : 'none';
                        uploadArea.style.display = selectedValue === 'upload' ? 'block' : 'none';
                        }
                        
                        if (uploadInput) {
                        uploadInput.toggleAttribute('required', selectedValue === 'upload');
                        }

                        if (selectedValue === 'draw' && !signaturePadInstance && canvas) {
                            signaturePadInstance = initializeSignaturePad(canvas);
                        }
                    }

                    radioButtons.forEach(radio => radio.addEventListener('change', updateSignatureArea));
                    updateSignatureArea(); // Lancer au chargement
                }

                function initializeSignaturePad(canvas) {
                    if (!canvas) return null;

                    const hiddenInput = form.querySelector('#signature-data-morale');
                    const clearBtn = form.querySelector('#clear-signature-btn-morale-final');
                    let signaturePad = null;
                    let isInitialized = false;

                    const resizeCanvas = () => {
                        const ratio = Math.max(window.devicePixelRatio || 1, 1);
                        const parentWidth = canvas.parentElement.offsetWidth;

                        if (parentWidth > 0) {
                            canvas.width = parentWidth * ratio;
                            canvas.height = (canvas.offsetHeight || 200) * ratio;
                            canvas.getContext('2d').scale(ratio, ratio);

                            const data = signaturePad ? signaturePad.toData() : [];

                            signaturePad = new SignaturePad(canvas, {
                                backgroundColor: 'rgb(255, 255, 255)',
                                penColor: 'rgb(0, 0, 0)'
                            });
                            canvas.signaturePadInstance = signaturePad;

                            // Restaurer les données si elles existent
                            if (data.length > 0) {
                                signaturePad.fromData(data);
                            }

                            // Ajouter l'événement endStroke seulement une fois
                            if (!isInitialized) {
                                signaturePad.addEventListener('endStroke', () => {
                                    if (!signaturePad.isEmpty()) {
                                        const signatureData = signaturePad.toDataURL('image/png');
                                        hiddenInput.value = signatureData;
                                        const errorElement = form.querySelector('#signature-draw-error-morale');
                                        if (errorElement) errorElement.style.display = 'none';
                                    } else {
                                        hiddenInput.value = '';
                                    }
                                });
                                isInitialized = true;
                            }
                        }
                    };

                    const resizeObserver = new ResizeObserver(resizeCanvas);
                    resizeObserver.observe(canvas.parentElement);

                    resizeCanvas();

                    if (clearBtn) {
                    clearBtn.addEventListener('click', () => {
                        if (signaturePad) {
                            signaturePad.clear();
                        }
                        hiddenInput.value = '';
                            const errorElement = form.querySelector('#signature-draw-error-morale');
                            if (errorElement) errorElement.style.display = 'none';
                    });
                    }

                    return signaturePad;
                }

                // Initialiser la signature
                setupSignatureChoice();
                // ==== FIN FONCTIONS SIGNATURE CORRIGÉES ====

                // Fonction pour sauvegarder la signature avant soumission
                form.addEventListener('submit', function(e) {
                    // ==== VALIDATION OBLIGATOIRE DES CHECKBOXES UMOA ====
                    const umoaCheckboxes = form.querySelectorAll('.consent-checkboxes input[type="checkbox"]');
                    let uncheckedCount = 0;

                    umoaCheckboxes.forEach(checkbox => {
                        if (!checkbox.checked) {
                            uncheckedCount++;
                        }
                    });

                    if (uncheckedCount > 0) {
                        e.preventDefault();
                        // Afficher un message d'erreur
                        Swal.fire({
                            icon: 'warning',
                            title: 'Consentements UMOA requis',
                            html: `
                                <div class="text-center">
                                    <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                                    <p><strong>Vous devez accepter tous les consentements UMOA pour continuer.</strong></p>
                                    <p class="text-muted">${uncheckedCount} consentement(s) manquant(s)</p>
                                </div>
                            `,
                            confirmButtonText: 'Comprendre',
                            confirmButtonColor: '#EC281C',
                            background: '#fff'
                        });

                        // Aller à l'étape 5 (UMOA)
                        currentStep = 5;
                        showStep(currentStep);

                        // Mettre en évidence les checkboxes non cochés
                        umoaCheckboxes.forEach(checkbox => {
                            if (!checkbox.checked) {
                                checkbox.classList.add('is-invalid');
                            }
                        });

                        // Afficher le message d'erreur général
                        let generalError = document.querySelector('.umoa-general-error');
                        if (!generalError) {
                            generalError = document.createElement('div');
                            generalError.className = 'umoa-general-error alert alert-danger mt-3';
                            generalError.innerHTML = `
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Attention :</strong> Vous devez accepter tous les consentements UMOA pour continuer. 
                                <span class="badge bg-danger ms-2">${uncheckedCount} consentement(s) manquant(s)</span>
                            `;
                            const consentContainer = document.querySelector('.consent-checkboxes');
                            if (consentContainer) {
                                consentContainer.after(generalError);
                            }
                        }

                        return false;
                    }

                    // ==== VALIDATION DE LA SIGNATURE ====
                    const signatureMethod = form.querySelector('input[name="signature_method"]:checked');
                    if (signatureMethod && signatureMethod.value === 'draw') {
                        const canvas = form.querySelector('#signature-pad-morale');
                        const signaturePad = canvas.signaturePadInstance;
                        const hiddenInput = form.querySelector('#signature-data-morale');

                        if (signaturePad && !signaturePad.isEmpty()) {
                            const signatureData = signaturePad.toDataURL('image/png');
                            console.log('Saving signature before submit, length:', signatureData.length);
                            hiddenInput.value = signatureData;
                        } else {
                            console.log('Signature pad is empty or not available');
                            e.preventDefault();

                            Swal.fire({
                                icon: 'warning',
                                title: 'Signature requise',
                                text: 'Veuillez dessiner ou importer votre signature avant de continuer.',
                                confirmButtonText: 'Comprendre',
                                confirmButtonColor: '#EC281C',
                                background: '#fff'
                            });

                            form.querySelector('#signature-draw-error-morale').style.display = 'block';
                            // Aller à l'étape 5
                            currentStep = 5;
                            showStep(currentStep);
                            return false;
                        }
                    } else if (signatureMethod && signatureMethod.value === 'upload') {
                        const signatureUpload = form.querySelector('input[name="signature_upload"]');
                        if (!signatureUpload.files.length) {
                            e.preventDefault();

                            Swal.fire({
                                icon: 'warning',
                                title: 'Signature requise',
                                text: 'Veuillez importer votre signature avant de continuer.',
                                confirmButtonText: 'Comprendre',
                                confirmButtonColor: '#EC281C',
                                background: '#fff'
                            });

                            signatureUpload.closest('.file-upload-wrapper').classList.add('is-invalid');
                            // Aller à l'étape 5
                            currentStep = 5;
                            showStep(currentStep);
                            return false;
                        }
                    } else {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'warning',
                            title: 'Méthode de signature requise',
                            text: 'Veuillez choisir une méthode de signature (dessiner ou importer).',
                            confirmButtonText: 'Comprendre',
                            confirmButtonColor: '#EC281C',
                            background: '#fff'
                        });

                        // Aller à l'étape 5
                        currentStep = 5;
                        showStep(currentStep);
                        return false;
                    }

                    // ==== TOUTES LES VALIDATIONS SONT PASSÉES - SOUMISSION ====
                    // Afficher le loader SweetAlert avant soumission
                    Swal.fire({
                        title: 'Envoi en cours...',
                        text: 'Votre adhésion est en cours de transmission',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });

                // Code supprimé car les éléments n'existent pas dans ce formulaire

                // ==== PRÉVISUALISATION PHOTO DES RESPONSABLES ====
                const responsiblePhotoInput = form.querySelector('#responsible-photo-input');
                if (responsiblePhotoInput) {
                    responsiblePhotoInput.addEventListener('change', function() {
                        const file = this.files[0];
                        const previewContainer = this.closest('.file-upload-wrapper').querySelector('.file-upload-preview');

                        if (file) {
                            if (file.type.startsWith('image/')) {
                                // Prévisualisation d'image
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    previewContainer.innerHTML = `
                                        <div class="preview-container">
                                            <img src="${e.target.result}" alt="Aperçu de la photo">
                                            <button type="button" class="remove-preview" onclick="removePhotoPreview('${this.id}')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    `;
                                }.bind(this);
                                reader.readAsDataURL(file);
                            } else {
                                // Informations sur le fichier
                                previewContainer.innerHTML = `
                                    <div class="file-info">
                                        <div class="file-name">${file.name}</div>
                                        <div class="file-size">${(file.size / 1024).toFixed(1)} KB</div>
                                        <button type="button" class="remove-preview" onclick="removePhotoPreview('${this.id}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                `;
                            }
                            // Supprimer la classe d'erreur si elle existe
                            this.closest('.file-upload-wrapper').classList.remove('is-invalid');
                        } else {
                            previewContainer.innerHTML = '';
                        }
                    });
                }

                // Fonction pour supprimer la prévisualisation
                window.removePhotoPreview = function(inputId) {
                    const input = document.getElementById(inputId);
                    const previewContainer = input.closest('.file-upload-wrapper').querySelector('.file-upload-preview');
                    input.value = '';
                    previewContainer.innerHTML = '';

                    // Réappliquer la classe d'erreur si le champ est requis
                    if (input.hasAttribute('required')) {
                        input.closest('.file-upload-wrapper').classList.add('is-invalid');
                    }
                };
                // ==== FIN PRÉVISUALISATION PHOTO DES RESPONSABLES ====

                // ==== GESTION DES MESSAGES DE SUCCÈS/ERREUR AVEC SWEETALERT2 ====
                // Détecter les messages de succès au chargement de la page
                const successMessage = document.querySelector('.alert-success');
                if (successMessage) {
                    const messageText = successMessage.textContent.trim();
                                    Swal.fire({
                    icon: "success",
                    title: "Adhésion réussie ! 🎉",
                    text: messageText,
                    confirmButtonColor: "#EC281C",
                    background: "#fff",
                    showConfirmButton: true,
                    allowOutsideClick: true
                });
                    // Supprimer le message HTML après affichage du popup
                    successMessage.remove();
                }

                // Détecter les messages d'erreur au chargement de la page
                const errorMessage = document.querySelector('.alert-danger');
                if (errorMessage) {
                    const messageText = errorMessage.textContent.trim();
                    Swal.fire({
                        icon: "warning",
                        title: "Oups...",
                        text: messageText,
                        confirmButtonColor: "#EC281C",
                        background: "#fff",
                        showConfirmButton: true,
                        allowOutsideClick: true
                    });
                    // Supprimer le message HTML après affichage du popup
                    errorMessage.remove();
                }

                // Détecter les messages d'erreur de validation au chargement de la page
                const validationErrors = document.querySelector('.alert-danger ul');
                if (validationErrors) {
                    const errorList = Array.from(validationErrors.querySelectorAll('li')).map(li => li.textContent.trim());
                    const errorMessage = errorList.join('\n• ');
                    Swal.fire({
                        icon: "warning",
                        title: "Erreurs de validation",
                        html: `<div style="text-align: left;"><strong>Veuillez corriger les erreurs suivantes :</strong><br><br>• ${errorMessage}</div>`,
                        confirmButtonColor: "#EC281C",
                        background: "#fff",
                        showConfirmButton: true,
                        allowOutsideClick: true
                    });
                    // Supprimer le message HTML après affichage du popup
                    validationErrors.closest('.alert-danger').remove();
                }
                // ==== FIN GESTION DES MESSAGES AVEC SWEETALERT2 ====

                showStep(currentStep);
            });
        });
    });

    // ==== VALIDATION EN TEMPS RÉEL DES CHECKBOXES UMOA ====
    function setupUmoaCheckboxValidationMorale() {
        const checkboxes = document.querySelectorAll('.consent-checkboxes input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                validateUmoaCheckboxesMorale();
            });
        });
    }

    function validateUmoaCheckboxesMorale() {
        const checkboxes = document.querySelectorAll('.consent-checkboxes input[type="checkbox"]');
        let uncheckedCount = 0;

        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.classList.add('is-invalid');
                uncheckedCount++;
            } else {
                checkbox.classList.remove('is-invalid');
                // Supprimer le message d'erreur individuel
                const errorDiv = checkbox.parentNode.querySelector('.umoa-checkbox-error');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
        });

        // Gérer le message d'erreur général
        let generalError = document.querySelector('.umoa-general-error');
        if (uncheckedCount > 0) {
            if (!generalError) {
                generalError = document.createElement('div');
                generalError.className = 'umoa-general-error alert alert-danger mt-3';
                generalError.innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Attention :</strong> Vous devez accepter tous les consentements UMOA pour continuer. 
                    <span class="badge bg-danger ms-2">${uncheckedCount} consentement(s) manquant(s)</span>
                `;
                const consentContainer = document.querySelector('.consent-checkboxes');
                if (consentContainer) {
                    consentContainer.after(generalError);
                }
            } else {
                // Mettre à jour le compteur
                const badge = generalError.querySelector('.badge');
                if (badge) {
                    badge.textContent = `${uncheckedCount} consentement(s) manquant(s)`;
                }
            }
        } else {
            if (generalError) {
                generalError.remove();
            }
        }
    }

    // Initialiser la validation en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        setupUmoaCheckboxValidationMorale();
    });

</script>
@endsection