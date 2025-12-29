<?php
namespace App\Services;


use App\Models\ConstitutionArticle;
use App\Models\RightCategory;
use App\Models\SupportingLaw;
use App\Models\EventRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
/**
 * Olay Analiz Servisi
 * 
 * Kullanıcının girdiği olayı analiz eder, ilgili anayasa maddelerini
 * ve hak kategorilerini tespit eder.
 * 
 * ÖNEMLİ: Bu servis hukuki danışmanlık yapmaz, sadece bilgilendirme amaçlıdır.
 */
class EventAnalysisService
{
    /**
     * Olayı analiz et ve sonuçları döndür
     * 
     * @param string $eventDescription Kullanıcının girdiği olay açıklaması
     * @return array Analiz sonuçları
     */
    public function analyzeEvent(string $eventDescription): array
    {
        /* 1.Anahtar kelimeleri Cıkar */
        $keywords = $this->extractKeywords($eventDescription);

        /* 2.olayi hak kategorilerini teespit et*/
        $rightCategories = $this->detectRightCategories($keywords, $eventDescription);

        /* 3.İlgili anayasa kanunları getir. */
        $constitutionArticles = $this->findRelevantArticles($keywords, $rightCategories, $eventDescription);

        $supportingLaws = $this->getSupportingLaws($constitutionArticles);

        // 5. Analiz sonuçlarını formatla
        return $this->formatAnalysisResult(
            $eventDescription,
            $keywords,
            $rightCategories,
            $constitutionArticles,
            $supportingLaws,
        );
    }
    /**
     * Metinden anahtar kelimeleri çıkar
     * 
     * @param string $text
     * @return array
     */
    protected function extractKeywords(string $text): array
    {
        //Türkçe Stop words (gerksiz kelimeler)  
        $stopWords = [
            'bir',
            'bu',
            'şu',
            'o',
            've',
            'ile',
            'için',
            'gibi',
            'kadar',
            'kadar',
            'daha',
            'çok',
            'az',
            'en',
            'da',
            'de',
            'ki',
            'mi',
            'mu',
            'mü',
            'var',
            'yok',
            'olmak',
            'etmek',
            'yapmak',
            'gelmek',
            'gitmek',
            'ben',
            'sen',
            'biz',
            'siz',
            'onlar',
            'benim',
            'senin',
            'onun'

        ];

        $text=mb_strtolower($text,'UTF-8');
        $text=
    }


}
