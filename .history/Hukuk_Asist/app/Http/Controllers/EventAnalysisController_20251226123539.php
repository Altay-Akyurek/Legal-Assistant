<?php

namespace App\Http\Controllers;

use App\Services\EventAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/* Olay Analiz Controller */
/* Kullanıcıların girdiği olayları analiz eder ve sonuçları gösterir.
Hukuki danışmaklık yapmaz Sadece Bilgilendirme amaçlıdır. */
class EventAnalysisController extends Controller
{
    protected $analysisService;

    public function __construct(EventAnalysisController $analysisService)
    {
        $this->analysisService=$analysisService;
    }

    /* Ana Sayfa  - Olay giriş formu */
    public function index(){
        return view('event-analysis.index');
    }

    public function analyze(Request $request){
        //validasyon
        $validator=Validator::make($request->all()[
            'event_description'=>[
                'required',
                'string',
                'min:20',
                'max:5000',
            ],
        ],[
            'event_description.required' => 'Lütfen yaşadığınız olayı açıklayın',
            'event_description.min'=>'Olay açıklaması en az 20 karakter olmalıdır.',
            'event_description.max'=>'Olay açıklaması en fazla 5000 karakter olabilir.',
        ]);
        if($validator ->fails()){
            return redirect()->route('event-analysis.index')
            ->withErrors($validator)
            ->withInput();
        }

        try{
            $analysisResult=$this->analysisService->analyzeEvent(
                $request -> input('event_description')
            );

            //Olay kaydet(anonim);
            $this->analysisService->saveEventRecord(
                $request->input('event_description'),
                $analysisResult,
                session()->getId()
            );

            //Sonuçları Göster
            return view('event-analysis.result'[
                'analysis'=>$analysisResult,
            ]);
        }catch(\Exception $e){
            \Log::error('Event analysis error:' .$e->getMessage());

            return redirect()->route('event-analysis.index')
            ->with('error','Analiz sırasında bir hata oluştu.Lütfen tekrar deneyin')
            ->withInput();
        }
    }
}
