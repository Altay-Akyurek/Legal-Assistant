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
                                        
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
          </div>
          
          @endif
    </div>
</div>

@endsection
