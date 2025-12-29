<?php

namespace App\Http\Controllers;

use App\Services\EventAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Olay Analiz Controller
 * 
 * Kullanıcıların girdiği olayları analiz eder ve sonuçları gösterir.
 * Hukuki danışmanlık yapmaz, sadece bilgilendirme amaçlıdır.
 */
class EventAnalysisController extends Controller
{
    protected $analysisService;

    public function __construct(EventAnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    /**
     * Ana sayfa - Olay giriş formu
     */
    public function index()
    {
        return view('event-analysis.index');
    }

    /**
     * Olay analizi yap ve sonuçları göster
     */
    public function analyze(Request $request)
    {
        // Validasyon
        $validator = Validator::make($request->all(), [
            'event_description' => [
                'required',
                'string',
                'min:20',
                'max:5000',
            ],
        ], [
            'event_description.required' => 'Lütfen yaşadığınız olayı açıklayın.',
            'event_description.min' => 'Olay açıklaması en az 20 karakter olmalıdır.',
            'event_description.max' => 'Olay açıklaması en fazla 5000 karakter olabilir.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('event-analysis.index')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Olayı analiz et
            $analysisResult = $this->analysisService->analyzeEvent(
                $request->input('event_description')
            );

            // Olayı kaydet (anonim)
            $this->analysisService->saveEventRecord(
                $request->input('event_description'),
                $analysisResult,
                session()->getId()
            );

            // Sonuçları göster
            return view('event-analysis.result', [
                'analysis' => $analysisResult,
            ]);

        } catch (\Exception $e) {
            // Hata durumunda logla ve kullanıcıya bilgi ver
            \Log::error('Event analysis error: ' . $e->getMessage());

            return redirect()->route('event-analysis.index')
                ->with('error', 'Analiz sırasında bir hata oluştu. Lütfen tekrar deneyin.')
                ->withInput();
        }
    }
}
