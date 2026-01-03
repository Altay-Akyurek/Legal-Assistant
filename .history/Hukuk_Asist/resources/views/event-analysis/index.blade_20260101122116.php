@extends('layouts.app')

@section('title', 'Olay Analizi - Ana Sayfa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-file-text"></i> Yaşadığınız Olayı Açıklayın
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Lütfen yaşadığınız olayı detaylı bir şekilde açıklayın. Sistem, olayınızı analiz ederek 
                    ilgili anayasa maddelerini ve temel haklarınızı tespit edecektir.
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
                        @error('event_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <ai class="bi bi-lightbulb"></ai> <strong>İpucu:</strong> 
                        Olayınızı açıklarken şu bilgileri eklemek faydalı olabilir:
                        <ul class="mb-0 mt-2">
                            <li>Ne zaman ve nerede oldu?</li>
                            <li>Kim veya hangi kurum tarafından yapıldı?</li>
                            <li>Hangi işlemler yapıldı?</li>
                            <li>Size nasıl bir etkisi oldu?</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-search"></i> Analiz Et
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bilgilendirme Kartları -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-shield-check" style="font-size: 3rem; color: var(--primary-color);"></i>
                        <h5 class="mt-3">Anayasa Merkezli</h5>
                        <p class="text-muted">Tüm değerlendirmeler Türkiye Cumhuriyeti Anayasası'na dayanır.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-lock" style="font-size: 3rem; color: var(--secondary-color);"></i>
                        <h5 class="mt-3">Gizlilik</h5>
                        <p class="text-muted">Tüm veriler anonim olarak saklanır. KVKK uyumludur.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-info-circle" style="font-size: 3rem; color: var(--warning-color);"></i>
                        <h5 class="mt-3">Bilgilendirme</h5>
                        <p class="text-muted">Sistem sadece bilgilendirme amaçlıdır, hukuki danışmanlık yapmaz.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('analysisForm').addEventListener('submit', function(e) {
        const textarea = document.getElementById('event_description');
        const value = textarea.value.trim();
        
        if (value.length < 20) {
            e.preventDefault();
            alert('Lütfen en az 20 karakter girin.');
            textarea.focus();
            return false;
        }
    });
</script>
@endpush
@endsection

