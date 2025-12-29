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
        // 1. Anahtar kelimeleri çıkar
        $keywords = $this->extractKeywords($eventDescription);

        // 2. Olası hak kategorilerini tespit et
        $rightCategories = $this->detectRightCategories($keywords, $eventDescription);

        // 3. İlgili anayasa maddelerini bul
        $constitutionArticles = $this->findRelevantArticles($keywords, $rightCategories, $eventDescription);

        // 4. Destekleyici kanunları getir
        $supportingLaws = $this->getSupportingLaws($constitutionArticles);

        // 5. Analiz sonuçlarını formatla
        return $this->formatAnalysisResult(
            $eventDescription,
            $keywords,
            $rightCategories,
            $constitutionArticles,
            $supportingLaws
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
        // Türkçe stop words (gereksiz kelimeler)
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

        // Metni küçük harfe çevir ve temizle
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);

        // Kelimelere ayır
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        // Stop words'leri filtrele ve minimum 3 karakter olanları al
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return mb_strlen($word) >= 3 && !in_array($word, $stopWords);
        });

        // Tekrarları kaldır ve sırala
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

            // Anahtar kelimelerle eşleşme kontrolü
            foreach ($keywords as $keyword) {
                if (in_array($keyword, $categoryKeywords)) {
                    $score += 10;
                }
            }

            // Kategori adı ve açıklamasında geçen kelimeler
            $categoryText = mb_strtolower($category->name . ' ' . ($category->description ?? ''), 'UTF-8');
            foreach ($keywords as $keyword) {
                if (mb_strpos($categoryText, $keyword) !== false) {
                    $score += 5;
                }
            }

            // Olay açıklamasında kategori adı geçiyor mu?
            $eventLower = mb_strtolower($eventDescription, 'UTF-8');
            if (mb_strpos($eventLower, mb_strtolower($category->name, 'UTF-8')) !== false) {
                $score += 15;
            }

            if ($score > 0) {
                $matchedCategories[] = [
                    'category' => $category,
                    'score' => $score,
                ];
            }
        }

        // Skora göre sırala (yüksekten düşüğe)
        usort($matchedCategories, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // En yüksek skorlu 5 kategoriyi al
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
    protected function findRelevantArticles(array $keywords, array $rightCategories, string $eventDescription): array
    {
        $matchedArticles = [];

        // 1. Hak kategorilerine göre anayasa maddelerini bul
        $categoryIds = array_map(function ($item) {
            return $item['category']->id;
        }, $rightCategories);

        if (!empty($categoryIds)) {
            $articles = ConstitutionArticle::active()
                ->whereHas('rightCategories', function ($query) use ($categoryIds): void {
                    $query->whereIn('right_categories.id', $categoryIds);
                })
                ->with('rightCategories')
                ->ordered()
                ->get();

            foreach ($articles as $article) {
                $score = 50; // Kategori eşleşmesi temel skor

                // Anahtar kelimelerle eşleşme
                $articleKeywords = $article->keywords ?? [];
                foreach ($keywords as $keyword) {
                    if (in_array($keyword, $articleKeywords)) {
                        $score += 10;
                    }
                }

                // Madde metninde anahtar kelime geçiyor mu?
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

        // 2. Doğrudan anahtar kelime eşleşmesi
        foreach ($keywords as $keyword) {
            $articles = ConstitutionArticle::active()
                ->byKeyword($keyword)
                ->with('rightCategories')
                ->ordered()
                ->get();

            foreach ($articles as $article) {
                // Zaten eklenmiş mi kontrol et
                $exists = false;
                foreach ($matchedArticles as $matched) {
                    if ($matched['article']->id === $article->id) {
                        $exists = true;
                        $matched['score'] += 15; // Ekstra skor
                        break;
                    }
                }

                if (!$exists) {
                    $matchedArticles[] = [
                        'article' => $article,
                        'score' => 20, // Doğrudan eşleşme skoru
                    ];
                }
            }
        }

        // Skora göre sırala
        usort($matchedArticles, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // En yüksek skorlu 10 maddeyi al
        return array_slice($matchedArticles, 0, 10);
    }

    /**
     * Destekleyici kanunları getir
     * 
     * @param array $articles
     * @return array
     */
    protected function getSupportingLaws(array $articles): array
    {
        $laws = [];

        foreach ($articles as $item) {
            $article = $item['article'];
            $supportingLaws = SupportingLaw::where('constitution_article_id', $article->id)
                ->active()
                ->ordered()
                ->get();

            if ($supportingLaws->isNotEmpty()) {
                $laws[] = [
                    'article' => $article,
                    'laws' => $supportingLaws,
                ];
            }
        }

        return $laws;
    }

    /**
     * Analiz sonuçlarını formatla
     * 
     * @param string $eventDescription
     * @param array $keywords
     * @param array $rightCategories
     * @param array $constitutionArticles
     * @param array $supportingLaws
     * @return array
     */
    protected function formatAnalysisResult(
        string $eventDescription,
        array $keywords,
        array $rightCategories,
        array $constitutionArticles,
        array $supportingLaws
    ): array {
        return [
            'event_description' => $eventDescription,
            'detected_keywords' => $keywords,
            'right_categories' => array_map(function ($item) {
                return [
                    'id' => $item['category']->id,
                    'name' => $item['category']->name,
                    'description' => $item['category']->description,
                    'score' => $item['score'],
                ];
            }, $rightCategories),
            'constitution_articles' => array_map(function ($item) {
                return [
                    'id' => $item['article']->id,
                    'article_number' => $item['article']->article_number,
                    'title' => $item['article']->title,
                    'official_text' => $item['article']->official_text,
                    'simplified_explanation' => $item['article']->simplified_explanation,
                    'score' => $item['score'],
                ];
            }, $constitutionArticles),
            'supporting_laws' => $supportingLaws,
            'analysis_date' => now()->format('d.m.Y H:i'),
        ];
    }

    /**
     * Olayı kaydet (anonim)
     * 
     * @param string $eventDescription
     * @param array $analysisResult
     * @param string|null $sessionId
     * @return EventRecord
     */
    public function saveEventRecord(string $eventDescription, array $analysisResult, ?string $sessionId = null): EventRecord
    {
        return EventRecord::create([
            'event_description' => $eventDescription,
            'detected_keywords' => $analysisResult['detected_keywords'],
            'detected_right_categories' => array_map(function ($cat) {
                return $cat['id'];
            }, $analysisResult['right_categories']),
            'matched_articles' => array_map(function ($art) {
                return $art['id'];
            }, $analysisResult['constitution_articles']),
            'ip_address' => request()->ip(),
            'session_id' => $sessionId ?? session()->getId(),
            'analyzed_at' => now(),
        ]);
    }
}

