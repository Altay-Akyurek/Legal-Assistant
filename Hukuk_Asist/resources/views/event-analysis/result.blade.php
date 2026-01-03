@extends('layouts.app')

@section('title', 'Detaylı Analiz Raporu')

@push('styles')
<style>
    .article-num-circle {
        width: 55px; height: 55px;
        background: linear-gradient(135deg, var(--primary) 0%, #1e293b 100%);
        color: var(--accent);
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px; font-weight: 700; font-size: 1.3rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .reason-tag {
        background: rgba(212, 175, 55, 0.1);
        color: #856404;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 0.75rem;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }
    .pro-guide-card {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        color: white;
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }
    .pro-guide-card .card-body {
        position: relative;
        z-index: 1;
    }
    .pro-guide-card::after {
        content: '\F54A'; /* bi-shield-shaded */
        font-family: 'bootstrap-icons';
        position: absolute;
        right: -20px; bottom: -20px;
        font-size: 10rem;
        opacity: 0.05;
        z-index: 0;
    }
</style>
@endpush

@section('content')
<div class="row align-items-center mb-5 animate-fade-in">
    <div class="col-md-7">
        <h2 class="fw-bold mb-1">Analiz Raporu</h2>
        <p class="text-muted small">Algoritmamız olayınızı {{ count($analysis['detected_keywords']) }} farklı kavram üzerinden inceledi.</p>
    </div>
    <div class="col-md-5 text-md-end">
        <a href="{{ route('event-analysis.index') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">
            <i class="bi bi-arrow-left me-1"></i> Yeni Sorgu
        </a>
        <button onclick="window.print()" class="btn btn-premium rounded-pill px-4">
            <i class="bi bi-file-earmark-pdf me-1"></i> Raporu İndir
        </button>
    </div>
</div>

<!-- Olay Özeti -->
<div class="card glass-card border-0 mb-5 animate-fade-in shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex align-items-center mb-3">
            <span class="badge bg-primary bg-opacity-10 text-primary p-2 rounded me-3">
                <i class="bi bi-chat-left-quote-fill fs-5"></i>
            </span>
            <h5 class="fw-bold mb-0">İncelenen Vakıa</h5>
        </div>
        <div class="p-3 bg-light rounded-3 italic text-secondary border-start border-4 border-primary">
            "{{ $analysis['event_description'] }}"
        </div>
    </div>
</div>

<!-- Kategori ve Rehberlik -->
@if(!empty($analysis['right_categories']))
<div class="mb-5">
    <h5 class="fw-bold mb-4 animate-fade-in"><i class="bi bi-compass-fill text-accent me-2"></i>Hak Kategorileri & Davranış Rehberi</h5>
    <div class="row g-4">
        @foreach($analysis['right_categories'] as $category)
        <div class="col-12 animate-fade-in">
            <div class="card glass-card border-0 shadow-sm overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-4 p-4 border-end bg-light bg-opacity-50">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h6 class="fw-bold text-primary mb-0">{{ $category['name'] }}</h6>
                            <span class="badge rounded-pill bg-accent text-primary fw-bold">%{{ $category['score'] }} Eşleşme</span>
                        </div>
                        <p class="small text-muted mb-3">{{ $category['description'] }}</p>
                        
                        <div class="mt-2">
                            <span class="text-uppercase x-small fw-bold text-muted d-block mb-2">Eşleşme Dayanağı</span>
                            @foreach($category['reasons'] as $reason)
                                <div class="reason-tag"><i class="bi bi-info-circle me-1"></i>{{ $reason }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-8 p-4">
                        @if($category['detailed_guide'])
                        <div class="h-100">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check text-success me-2"></i>Nasıl Davranmalısınız?</h6>
                            <div class="small lh-lg p-3 rounded-3 bg-success bg-opacity-10 text-dark border border-success border-opacity-10">
                                {!! nl2br(e($category['detailed_guide'])) !!}
                            </div>
                        </div>
                        @else
                        <p class="text-muted small">Bu kategori için spesifik bir rehber bulunamadı, genel hukuk ilkelerini takip edin.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Anayasa Maddeleri -->
@if(!empty($analysis['constitution_articles']))
<div class="mb-5">
    <h5 class="fw-bold mb-4 animate-fade-in"><i class="bi bi-bank text-accent me-2"></i>Dayanak Anayasa Maddeleri</h5>
    @foreach($analysis['constitution_articles'] as $article)
    <div class="card glass-card border-0 mb-4 animate-fade-in shadow-sm">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-2 d-none d-md-flex justify-content-center">
                    <div class="article-num-circle">M{{ $article['article_number'] }}</div>
                </div>
                <div class="col-md-10">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-bold text-primary mb-0">{{ $article['title'] }}</h5>
                        <div class="text-end">
                            <span class="badge bg-light text-dark px-3 py-2 border">Skor: {{ $article['score'] }}</span>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-3 border">
                        <small class="text-uppercase fw-bold text-muted mb-1 d-block">Resmî Madde Metni</small>
                        <p class="small mb-0 text-dark italic">{{ $article['official_text'] }}</p>
                    </div>

                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 mb-3">
                        <h6 class="fw-bold small text-primary mb-1"><i class="bi bi-stars me-1"></i>Sanal Asistan Analizi</h6>
                        <p class="small mb-0 text-primary-emphasis fw-medium">{{ $article['simplified_explanation'] }}</p>
                    </div>

                    <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                        @foreach($article['reasons'] as $reason)
                            <span class="x-small text-muted"><i class="bi bi-diagram-3 me-1"></i>{{ $reason }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- İlgili Kanunlar -->
@if(!empty($analysis['supporting_laws']))
<div class="mb-5 animate-fade-in">
    <h5 class="fw-bold mb-4 text-center"><i class="bi bi-journal-bookmark-fill text-accent me-2"></i>Alt Mevzuat & Uygulama Kanunları</h5>
    <div class="row g-4">
        @foreach($analysis['supporting_laws'] as $lawGroup)
            @foreach($lawGroup['laws'] as $law)
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; border-top: 4px solid #3b82f6 !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-file-earmark-ruled text-primary fs-4 me-2"></i>
                            <h6 class="fw-bold mb-0">{{ $law->law_name }}</h6>
                        </div>
                        <p class="x-small text-primary fw-bold mb-2">İlgili Madde: {{ $law->relevant_articles }}</p>
                        <p class="small text-muted mb-0 lh-base">{{ $law->description }}</p>
                    </div>
                    <div class="card-footer bg-light border-0 py-2 px-4 text-end">
                        <span class="x-small fw-bold text-secondary">Kanun No: {{ $law->law_number }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>
</div>
@endif

<!-- Sonuç ve Güvenlik Mesajı -->
<div class="pro-guide-card card mb-5 animate-fade-in">
    <div class="card-body p-5 text-center">
        <h3 class="fw-bold text-accent mb-3">Hukuki Güvenliğiniz Bizim İçin Önemli</h3>
        <p class="opacity-75 mb-4">Bu analiz süreci tamamen anonimdir. Hiçbir veriniz gerçek kimliğinizle ilişkilendirilmez.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="https://www.barobirlik.org.tr/" target="_blank" class="btn btn-accent px-4 py-2 text-primary fw-bold rounded-pill">Barolara Ulaşın</a>
            <a href="#" class="btn btn-outline-light px-4 py-2 rounded-pill">AYM Başvuru Formu</a>
        </div>
    </div>
</div>
@endsection
