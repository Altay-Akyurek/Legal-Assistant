<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sanal Hukuk Asistanı') - Türkiye Cumhuriyeti Anayasası</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom Modern Theme -->
    <link rel="stylesheet" href="{{ asset('css/modern_theme.css') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg nav-glass sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('event-analysis.index') }}">
                <i class="bi bi-shield-check-fill text-accent me-2"
                    style="color: var(--accent); font-size: 1.5rem;"></i>
                <span style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">Sanal Hukuk Asistanı</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('event-analysis.index') }}">
                            <i class="bi bi-house-door me-1"></i> Ana Sayfa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3"
                            href="https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=2709&MevzuatTur=1&MevzuatTertip=5"
                            target="_blank">
                            <i class="bi bi-book me-1"></i> Anayasa
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Legal Warning -->
    <div class="container mt-4 animate-fade-in">
        <div class="legal-warning-modern d-flex align-items-start">
            <i class="bi bi-exclamation-triangle-fill text-warning me-3" style="font-size: 1.5rem;"></i>
            <div>
                <h6 class="mb-1 text-dark fw-bold">ÖNEMLİ YASAL UYARI</h6>
                <p class="mb-0 text-muted small">
                    Bu sistem yapay zeka destekli bir bilgilendirme platformudur ve kesinlikle <strong>hukuki
                        danışmanlık hizmeti değildir</strong>.
                    Verilen bilgiler rehberlik amaçlı olup, hukuki kararlarınız için mutlaka bir avukata danışmalısınız.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container py-2 animate-fade-in">
        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#0f172a'
                });
            </script>
        @endif

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Başarılı!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0f172a'
                });
            </script>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-modern mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-5">
                    <h5 class="mb-3">Sanal Hukuk Asistanı</h5>
                    <p class="small">
                        Türkiye Cumhuriyeti Anayasası merkezli, temel hak ve özgürlükler konusunda
                        toplumsal farkındalık oluşturmayı amaçlayan dijital bir rehberdir.
                    </p>
                    <div class="d-flex gap-3 mt-3">

                        <a href="https://www.linkedin.com/in/altay-aky%C3%BCrek/"
                            class="text-white opacity-50 hover-opacity-100"><i class="bi bi-linkedin"></i></a>
                        <a href="https://github.com/Altay-Akyurek" class="text-white opacity-50 hover-opacity-100"><i
                                class="bi bi-github"></i></a>
                    </div>
                </div>
                <div class="col-md-3 ms-auto">
                    <h5 class="mb-3">Hızlı Linkler</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('event-analysis.index') }}"
                                class="text-decoration-none text-white-50">Ana Sayfa</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white-50">Hakkımızda</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white-50">Kullanım Koşulları</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-3">Güvenlik & Gizlilik</h5>
                    <p class="small">
                        Verileriniz anonim olarak işlenmektedir. KVKK kapsamında kişisel bilgileriniz
                        asla saklanmaz ve üçüncü taraflarla paylaşılmaz.
                    </p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center pb-2">
                <p class="mb-0 x-small">&copy; {{ date('Y') }} Sanal Hukuk Asistanı. Tüm Hakları Saklıdır.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>