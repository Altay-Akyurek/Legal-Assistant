@extends('layouts.app')

@section('title', 'Olay Analizi - Ana Sayfa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Main Form Card -->
        <div class="card glass-card border-0 mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-file-earmark-text text-primary fs-3"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">Olay Analizi</h3>
                        <p class="text-muted mb-0">Yaşadığınız durumu detaylıca açıklayın, hukuki karşılığını bulalım.</p>
                    </div>
                </div>

                <form action="{{ route('event-analysis.analyze') }}" method="POST" id="analysisForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="event_description" class="form-label fw-semibold">
                            Hukuki Durum Açıklaması <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            class="form-control border-light shadow-sm @error('event_description') is-invalid @enderror" 
                            id="event_description" 
                            name="event_description" 
                            rows="8" 
                            style="border-radius: 12px; resize: none;"
                            placeholder="Örn: Polis tarafından durduruldum ve arama yapıldı. Arama sırasında hakim kararı gösterilmedi..."
                            required
                            minlength="20"
                            maxlength="5000"
                        >{{ old('event_description') }}</textarea>
                        <div class="form-text d-flex justify-content-between mt-2">
                            <span>Minimum 20 karakter girmelisiniz.</span>
                            <span id="charCount">0 / 5000</span>
                        </div>
                        @error('event_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="alert alert-info border-0 bg-info bg-opacity-10 p-3 h-100" style="border-radius: 12px;">
                                <h6 class="fw-bold"><i class="bi bi-lightbulb-fill me-2"></i>İpucu:</h6>
                                <p class="small mb-0 text-muted">
                                    Olayın <strong>nerede</strong>, <strong>ne zaman</strong> ve <strong>kiminle</strong> gerçekleştiğini belirtmek daha doğru sonuçlar verir.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-primary border-0 bg-primary bg-opacity-10 p-3 h-100" style="border-radius: 12px;">
                                <h6 class="fw-bold"><i class="bi bi-shield-lock-fill me-2"></i>Gizlilik:</h6>
                                <p class="small mb-0 text-muted">
                                    Girdiğiniz veriler anonim olarak işlenir. Kişisel verilerinizi girmenize gerek yoktur.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-premium btn-lg py-3" id="submitBtn">
                            <i class="bi bi-search me-2"></i> Analizi Başlat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Cards Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card glass-card border-0 h-100 text-center p-4">
                    <div class="display-6 text-accent mb-3"><i class="bi bi-mortarboard-fill"></i></div>
                    <h5 class="fw-bold">Akademik Temel</h5>
                    <p class="text-muted small">Tüm analizler anayasal maddeler ve akademik hukuk çerçevesinde yapılır.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card glass-card border-0 h-100 text-center p-4">
                    <div class="display-6 text-accent mb-3"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h5 class="fw-bold">Hızlı Analiz</h5>
                    <p class="text-muted small">Karmaşık hukuki metinleri saniyeler içinde analiz eder ve sadeleştirir.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card glass-card border-0 h-100 text-center p-4">
                    <div class="display-6 text-accent mb-3"><i class="bi bi-fingerprint"></i></div>
                    <h5 class="fw-bold">Tam Anonimlik</h5>
                    <p class="text-muted small">Cihazınızda saklanan hiçbir veri kimliğinizle ilişkilendirilmez.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const textarea = document.getElementById('event_description');
    const charCount = document.getElementById('charCount');
    const form = document.getElementById('analysisForm');
    const submitBtn = document.getElementById('submitBtn');

    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = `${length} / 5000`;
        
        if (length < 20) {
            charCount.classList.add('text-danger');
        } else {
            charCount.classList.remove('text-danger');
        }
    });

    form.addEventListener('submit', function(e) {
        const value = textarea.value.trim();
        
        if (value.length < 20) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Eksik Bilgi',
                text: 'Lütfen olayı en az 20 karakter ile açıklayın.',
                confirmButtonColor: '#0f172a'
            });
            return false;
        }

        // Show Loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Analiz Ediliyor...';
        
        Swal.fire({
            title: 'Analiz Başlatıldı',
            text: 'Anayasa maddeleri taranıyor, lütfen bekleyin...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>
@endpush
@endsection
