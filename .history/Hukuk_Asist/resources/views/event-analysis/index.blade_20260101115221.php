@extends('layouts.app')
@section('title','Olay Analizi - Ana Sayfa')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-file-text"></i>Yaşadığınız Olayı Açıklayın
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Lütfen yaşadığı olayı detaylı bir şekilde açıklayın . Sistem , olaylarınızı analiz ederek ilgili 
                    anayasa  maddelerini ve temel haklarınınız tespit edecektir.
                </p>
                <form action="{{ route('event-analysis.analyze') }}" method="POST" id="analysisForm">
                @csrf
                <div class="mb-3">
                    <label for="event_description" class="form-label">
                        <strong>Olay Açıklaması</strong> <span class="text-danger">*</span>
                    </label>
                    <textarea 
                            class="form-control @error('event_description') is-invalid @enderror" 
                            id="event_description" 
                            name="event_description" 
                            rows="10" 
                            placeholder="Örnek: Polis tarafından durduruldum ve arama yapıldı. Arama sırasında hakim kararı gösterilmedi..."
                            required
                            minlength="20"
                            maxlength="5000"
                        >{{ old('event_description') }}</textarea>
                        <div class="form-text">
                            Minimum 20, maksimum 5000 karakter. Olayı mümkün olduğunca detaylı açıklayın.
                        </div>
                </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection