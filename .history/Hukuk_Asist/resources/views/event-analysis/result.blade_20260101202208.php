@extends('leyouts.app')
@section('title','Analiz Sonuçları')
@section('content')
<div class="row">
    <div class="col-12">
        <!-- Başlık -->
         <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-clipboard-check"></i>Analiz Sonuçları
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">
                    <strong>Analiz Tarihi:</strong>{{ $analysis['analysis_date'] }}
                </p>
            </div>
         </div>

         <!-- Tespit edilen hak kategorileri -->
          @if (!empty($analysis['right_categories']))
          <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-tags"></i>Tespit Edilen Hak Kategorileri.
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Olaylayınızda etiketlenmiş olabilecek temel hak ve özgürlük kategorileri:
                </p>
                <div class="row">
                    @foreach ($analysis['right_categories'] as $category)
                        <div class="col-md-6 mb-3">
                            <div class="card article-card">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                             {{ $category['name'] }}
                                    </h6>
                                    @if ($category['description'])
                                    <p class="card-text text-muted small">{{ $category['description'] }}</p>
                                    @endif
                                    <small class="text-muted">
                                        <i class="bi bi-graph-up"></i>Eşleşme Skoru:{{ $category['score'] }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
          </div>
          @endif

          <!-- İlgili Anayasa Maddeleri-->
           @if (!empty($analysis['constitution_articles']))
           <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text"></i>İlgili Anayasa Maddeleri
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Olayınızla İlgili olabilecek Türkiye Cumhuriyeti Anayasası maddeleri:
                    </p>

                    @foreach ($analysis['constitution_articles'] as $article )
                        <div class="card article-card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">
                                        <span class="article-number">Madde{{ $article['article_number'] }}</span>
                                        <span class="ms-2">{{ $article['title'] }}</span>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-graph-up">Skor:{{ $article['score'] }}</i>
                                    </small>
                                </div>
                                <div class="mb-3">
                                    <strong>Resmi Metin:</strong>
                                    <p class="mt-2 text-justify">{{ $article['official_text'] }}</p>
                                </div>
                                @if ($article['simplified_explanation'])
                                <div class="alert alert-light">
                                    <strong><i class="bi bi-info-circle">Sadeleştirilmiş Açıklama:</i></strong>
                                    <p class="mb-0 mt-2">{{ $article['simplified_explanation'] }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
           </div>
           @endif

           <!-- Desteklekliyici Kanunlar -->
            @if (!empty($analysis['supporting_laws']))
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-book"></i>Destekleyici Kanunlar(Bilgilendirme Amaçlı)
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <strong>Not:</strong>Aşağıdaki kanunlar,ilgili anayasa maddelerini destekleyici niteliktedir.
                        Sadece bilgilendirme amaçlıdır.
                    </p>
                </div>
            </div>
            
            @endif
    </div>
</div>

@endsection
