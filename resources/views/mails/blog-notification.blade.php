<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel article sur le blog COCEC</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #EC281C, #C41E3A);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 20px;
        }
        .blog-title {
            color: #EC281C;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            line-height: 1.4;
        }
        .blog-excerpt {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .blog-image {
            width: 100%;
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #EC281C, #C41E3A);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }
        .cta-container {
            text-align: center;
            margin: 30px 0;
        }
        .divider {
            height: 2px;
            background: linear-gradient(90deg, #EC281C, #C41E3A);
            margin: 30px 0;
            border: none;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .footer a {
            color: #EC281C;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #EC281C;
            text-decoration: none;
            font-weight: bold;
        }
        .unsubscribe {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }
        .unsubscribe a {
            color: #999;
            text-decoration: underline;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }
        .contact-info strong {
            color: #EC281C;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .header {
                padding: 20px 15px;
            }
            .content {
                padding: 20px 15px;
            }
            .blog-title {
                font-size: 20px;
            }
            .cta-button {
                padding: 12px 25px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>COCEC - Microfinance</h1>
            <p>Nouvel article sur notre blog</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 class="blog-title">{{ $blog->title }}</h2>
            
            @if($blog->image)
                <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image) }}" 
                     alt="{{ $blog->title }}" 
                     class="blog-image">
            @endif
            
            <div class="blog-excerpt">
                {{ Str::limit(strip_tags($blog->short_description), 200) }}
            </div>

            <div class="cta-container">
                <a href="{{ $blogUrl }}" class="cta-button">
                    Lire l'article complet
                </a>
            </div>

            <hr class="divider">

            <div class="contact-info">
                <strong>COCEC - Votre partenaire financier de confiance</strong><br>
                📍 Quartier KANYIKOPE à 50m du Lycée FOLLY-BEBE<br>
                📞 (+228) 91 12 64 71 / 98 42 24 73<br>
                ✉️ cocec@cocectogo.org<br>
                🌐 <a href="{{ $siteUrl }}">{{ $siteUrl }}</a>
            </div>

            <div class="social-links">
                <a href="{{ $siteUrl }}/produits">Nos Produits</a>
                <a href="{{ $siteUrl }}/agences">Nos Agences</a>
                <a href="{{ $siteUrl }}/contact">Contact</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Vous recevez cet email car vous êtes abonné à la newsletter de la COCEC.<br>
                <a href="{{ $siteUrl }}">Visitez notre site web</a> pour découvrir tous nos services.
            </p>
            
            @if($unsubscribeToken)
                <div class="unsubscribe">
                    <a href="{{ $siteUrl }}/newsletter/unsubscribe?token={{ $unsubscribeToken }}">
                        Se désabonner de la newsletter
                    </a>
                </div>
            @endif
            
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                © {{ date('Y') }} COCEC. Tous droits réservés. | Propulsé par Angélot
            </p>
        </div>
    </div>
</body>
</html>
