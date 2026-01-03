@extends('layouts.app')

@section('title', 'Analiz Sonuçları')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Başlık -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-clipboard-check"></i> Analiz Sonuçları
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">
                    <strong>Analiz Tarihi:</strong> {{ $analysis['analysis_date'] }}
                </p>
            </div>
        </div>

        <!-- Tespit Edilen Hak Kategorileri -->
        @if(!empty($analysis['right_categories']))
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-tags"></i> Tespit Edilen Hak Kategorileri
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Olayınızda etkilenmiş olabilecek temel hak ve özgürlük kategorileri:
                </p>
                <div class="row">
                    @foreach($analysis['right_categories'] as $category)
                    <div class="col-md-6 mb-3">
                        <div class="card article-card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="bi bi-check-circle-fill text-success"></i> 
                                    {{ $category['name'] }}
                                </h6>
                                @if($category['description'])
                                    <p class="card-text text-muted small">{{ $category['description'] }}</p>
                                @endif
                                <small class="text-muted">
                                    <i class="bi bi-graph-up"></i> Eşleşme Skoru: {{ $category['score'] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- İlgili Anayasa Maddeleri -->
        @if(!empty($analysis['constitution_articles']))
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-text"></i> İlgili Anayasa Maddeleri
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Olayınızla ilgili olabilecek Türkiye Cumhuriyeti Anayasası maddeleri:
                </p>
                
                @foreach($analysis['constitution_articles'] as $article)
                <div class="card article-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0">
                                <span class="article-number">Madde {{ $article['article_number'] }}</span>
                                <span class="ms-2">{{ $article['title'] }}</span>
                            </h6>
                            <small class="text-muted">
                                <i class="bi bi-graph-up"></i> Skor: {{ $article['score'] }}
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <strong>Resmî Metin:</strong>
                            <p class="mt-2 text-justify">{{ $article['official_text'] }}</p>
                        </div>
                        
                        @if($article['simplified_explanation'])
                        <div class="alert alert-light">
                            <strong><i class="bi bi-info-circle"></i> Sadeleştirilmiş Açıklama:</strong>
                            <p class="mb-0 mt-2">{{ $article['simplified_explanation'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Destekleyici Kanunlar -->
        @if(!empty($analysis['supporting_laws']))
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-book"></i> Destekleyici Kanunlar (Bilgilendirme Amaçlı)
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    <strong>Not:</strong> Aşağıdaki kanunlar, ilgili anayasa maddelerini destekleyici niteliktedir. 
                    Sadece bilgilendirme amaçlıdır.
                </p>
                
                @foreach($analysis['supporting_laws'] as $lawGroup)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">
                            <span class="article-number">Madde {{ $lawGroup['article']->article_number }}</span>
                            <span class="ms-2">{{ $lawGroup['article']->title }}</span>
                        </h6>
                        
                        @foreach($lawGroup['laws'] as $law)
                        <div class="border-start border-primary ps-3 ms-3 mt-3">
                            <h6 class="mb-2">
                                <i class="bi bi-file-earmark-text"></i> 
                                {{ $law->law_name }}
                                @if($law->law_number)
                                    <small class="text-muted">({{ $law->law_number }})</small>
                                @endif
                            </h6>
                            
                            @if($law->relevant_articles)
                            <p class="mb-2">
                                <strong>İlgili Maddeler:</strong> {{ $law->relevant_articles }}
                            </p>
                            @endif
                            
                            @if($law->description)
                            <p class="text-muted small mb-0">{{ $law->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Genel Bilgilendirme -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle"></i> Önemli Bilgilendirme
                </h5>
            </div>
            <div class="card-body">
                <h6>Dikkat Edilmesi Gerekenler:</h6>
                <ul>
                    <li>Bu analiz, sadece bilgilendirme amaçlıdır ve hukuki danışmanlık değildir.</li>
                    <li>Kesin hüküm verilmez ve bağlayıcı görüş sunulmaz.</li>
                    <li>Her olay kendine özgüdür ve detaylı değerlendirme gerektirir.</li>
                    <li>Hukuki sorunlarınız için mutlaka bir avukata danışınız.</li>
                </ul>

                <h6 class="mt-4">Olası Başvuru Yolları:</h6>
                <ul>
                    <li><strong>İdari Başvuru:</strong> İlgili kamu kurumuna yazılı başvuru yapabilirsiniz.</li>
                    <li><strong>İdari Yargı:</strong> İdari işlemlere karşı idare mahkemelerine dava açabilirsiniz.</li>
                    <li><strong>Anayasa Mahkemesi:</strong> Temel hak ihlali durumunda bireysel başvuru yapabilirsiniz.</li>
                    <li><strong>Avukat:</strong> Hukuki danışmanlık için bir avukata başvurabilirsiniz.</li>
                    <li><strong>Baro:</strong> İl barosundan adli yardım talep edebilirsiniz.</li>
                </ul>
            </div>
        </div>

        <!-- Yasal Uyarı -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-shield-exclamation"></i> Yasal Uyarı
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    <strong>Bu sistem hukuki danışmanlık hizmeti değildir.</strong> Sistem, sadece bilgilendirme, 
                    farkındalık ve rehberlik amaçlıdır. Kesin hüküm vermez, avukatlık faaliyetine girmez ve 
                    bağlayıcı görüş sunmaz. Hukuki sorunlarınız için mutlaka bir avukata danışınız.
                </p>
            </div>
        </div>

        <!-- Yeni Analiz Butonu -->
        <div class="text-center mb-4">
            <a href="{{ route('event-analysis.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-left"></i> Yeni Analiz Yap
            </a>
        </div>
    </div>
</div>
@endsection

