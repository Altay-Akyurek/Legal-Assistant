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
        //metin küçük harfle çevir ve temizle
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);


        //kelimeleri ayır
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        //Stop words'leri filtrele ve minimum 3 karakter alanları al
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return mb_strlen($word) >= 3 && !in_array($word, $stopWords);
        });
        //tekrarları kaldır ve sırala
        $keywords = array_unique($keywords);
        sort($keywords);

        return array_values($keywords);
    }
    /**
     * Olası hak kategorilerini tespit et
     * 
     * @param array $keywords
     * @param string $eventDescription
     * @return array
     */
    protected function detectRightCategories(array $keywords, string $eventDescription): array
    {
        $categories = RightCategory::active()->ordered()->get();
        $matchedCategories = [];
        foreach ($categories as $category) {
            $score = 0;
            $categoryKeywords = $category->keywords ?? [];

            //Anahtar kelimelerle Eşleşme kontrolü 
            foreach ($keywords as $keyword) {
                if (in_array($keyword, $categoryKeywords)) {
                    $score += 10;
                }
            }
            //Kategori adı ve açıklmasında geçen kelimeler

            $categoryText = mb_strtolower($category->name . ' ' . ($category->description ?? ''), 'UTF-8');
            foreach ($keywords as $keyword) {
                if (mb_strpos($categoryText, $keyword) !== false) {
                    $score += 5;
                }
            }
            //Olay açıklamasında kategori adı geçiyor mu?
            $eventLower = mb_strtolower($eventDescription, 'UTF-8');
            if (mb_strpos($eventLower, mb_strtolower($category->name, 'UTF-8')) !== false) {
                $score += 5;
            }

            if ($score > 0) {
                $matchedCategories[] = [
                    'category' => $category,
                    'score' => $score,
                ];
            }
        }

        //Skora göre sırala(Yüksekten düşüğe)
        usort($matchedCategories, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });


        //En yüksek skoru 5 kateforiyi al

        return array_slice($matchedCategories, 0, 5);

    }
    /**
     * İlgili anayasa maddelerini bul
     * 
     * @param array $keywords
     * @param array $rightCategories
     * @param string $eventDescription
     * @return array
     */
    protected function findRelevantArticles(array $keyword, array $rightCategories, string $eventDescription): array
    {
        $matchedArticles = [];

        //1. Hak Kategorilerine göre anayasa maddeleri bul
        $categoryIds = array_map(function ($item) {
            return $item['category']->id;

        }, $rightCategories);

        if (!empty($categoryIds)) {
            $articles = ConstitutionArticle::active()
                ->whereHas('rightCategories', function ($query) use ($categoryIds) {
                    $query->whereIn('right_categories.id', $categoryIds);
                })
                ->with('rightCategories')
                ->ordered()
                ->get();

            foreach ($articles as $article) {
                $score = 50;//kategori eşleşmesi temel skor

                //Anahtar kelimelerle eşleşme
                $articleKeywords = $article->keywords ?? [];
                foreach ($keywords as $keyword) {
                    if (in_array($keyword, $articleKeywords)) {
                        $score += 10;
                    }
                }

                //madde metninde anahtar kelime geçiyormu?
                $articleText = mb_strtolower($article->title . ' ' . $article->official_text, 'UTF-8');
                foreach ($keywords as $keyword) {
                    if (mb_strpos($articleText, $keyword) !== false) {
                        $score += 5;
                    }
                }

                $matchedArticles[] = [
                    'article' => $article,
                    'score' => $score,
                ];
            }
        }

        //2.Doğrudan  anahtar kelime eşleşmesi
        foreach ($keywords as $keyword) {
            $articles = ConstitutionArticle::active()
                ->byKeyword($keyword)
                ->with('rightCategories')
                ->ordered()
                ->get();

            foreach ($articles as $article) {
                //Zaten eklenmiş mi kontrol et
                $exists = false;
                foreach ($matchedArticles as $matched) {
                    if ($matched['article']->id === $article->id) {
                        $exists = true;
                        $matched['score'] += 15;
                        break;
                    }
                }

                if (!$exists) {
                    $matchedArticles[] = [
                        'article' => $article,
                        'score' => 20,//doğrudan eşleşme skoru
                    ];
                }
            }
        }

        //skora göre sırala
        usort($matchedArticles, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_slice($matchedArticles, 0, 10);
    }


    /**
     * Destekleyici kanunları getir
     * 
     * @param array $articles
     * @return array
     */



}
