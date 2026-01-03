<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sanal Hukuk Asistanı') - Türkiye Cumhuriyeti Anayasası</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --warning-color: #f59e0b;
            --danger-color: #dc2626;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .legal-warning {
            background-color: #fff3cd;
            border-left: 4px solid var(--warning-color);
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 4px;
        }
        
        .legal-warning strong {
            color: var(--danger-color);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            font-weight: 600;
            border-radius: 8px 8px 0 0 !important;
        }
        
        .article-card {
            border-left: 4px solid var(--secondary-color);
            transition: transform 0.2s;
        }
        
        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .article-number {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('event-analysis.index') }}">
                <i class="bi bi-shield-check"></i> Sanal Hukuk Asistanı
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('event-analysis.index') }}">
                            <i class="bi bi-house"></i> Ana Sayfa
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Legal Warning Component -->
    <div class="container mt-3">
        <div class="legal-warning">
            <strong><i class="bi bi-exclamation-triangle"></i> ÖNEMLİ YASAL UYARI:</strong>
            Bu sistem hukuki danışmanlık hizmeti değildir. Sistem, sadece bilgilendirme, farkındalık ve rehberlik amaçlıdır. 
            Kesin hüküm vermez, avukatlık faaliyetine girmez ve bağlayıcı görüş sunmaz. 
            Hukuki sorunlarınız için mutlaka bir avukata danışınız.
        </div>
    </div>

    <!-- Main Content -->
    <main class="container">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-info-circle"></i> Hakkında</h5>
                    <p>
                        Bu sistem, Türkiye Cumhuriyeti Anayasası merkezli bir bilgilendirme platformudur. 
                        Temel hak ve özgürlükler konusunda farkındalık oluşturmayı amaçlar.
                    </p>
                </div>
                <div class="col-md-6">
                    <h5><i class="bi bi-shield-lock"></i> Gizlilik ve Güvenlik</h5>
                    <p>
                        Tüm veriler anonim olarak saklanır. KVKK uyumludur. 
                        Kişisel bilgileriniz toplanmaz ve paylaşılmaz.
                    </p>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Sanal Hukuk Asistanı. Tüm hakları saklıdır.</p>
                <p class="mb-0 mt-2">
                    <small>Bu sistem hukuki danışmanlık hizmeti değildir.</small>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

