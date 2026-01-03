<?php

namespace App\Services;

use App\Models\ConstitutionArticle;
use App\Models\RightCategory;
use App\Models\SupportingLaw;
use App\Models\EventRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

/**
 * Omni-Bridge Event Analysis Engine (V10.0 - Hyper-Resilience)
 * 
 * Bu sürüm hayatın her alanındaki 100+ senaryoyu (Trafik, Sağlık, Aile, Dijital vb.)
 * saptayacak devasa bir mantıksal köprüye sahiptir.
 */
class EventAnalysisService
{
    /**
     * Olayı analiz et ve sonuçları döndür
     */
    public function analyzeEvent(string $eventDescription): array
    {
        $normalizedText = $this->normalizeLegalText($eventDescription);
        $keywords = $this->extractKeywords($normalizedText);
        $rightCategories = $this->detectRightCategories($keywords, $normalizedText);
        $constitutionArticles = $this->findRelevantArticles($keywords, $rightCategories, $normalizedText);
        $supportingLaws = $this->getSupportingLaws($constitutionArticles);

        return $this->formatAnalysisResult(
            $eventDescription,
            $keywords,
            $rightCategories,
            $constitutionArticles,
            $supportingLaws
        );
    }

    /**
     * V10.0: Hyper-Resilience Semantic Bridge
     * Tüm kategorileri kapsayan devasa anlamsal eşleştirme.
     */
    protected function normalizeLegalText(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        
        $mapping = [
            // 🛡️ ÖZEL HAYAT & KİŞİLİK
            'isim' => 'ozel hayat kisisel veri mahremiyet',
            'ses kaydı' => 'ozel hayat gizlilik delil sucluluk',
            'takip' => 'hürriyet güvenlik taciz ısrarlı takip',
            'linç' => 'onur haysiyet manevi hakaret',
            'sahte hesap' => 'bilişim veri kimlik ozel hayat',
            'montaj' => 'ozel hayat gizlilik veri onur',
            
            // 🏠 KONUT & YAŞAM
            'ev sahibi' => 'konut mulkiyet kira sozlesme',
            'depozito' => 'mulkiyet borç alacak kira',
            'gürültü' => 'huzur mülkiyet idare',
            'elektrik' => 'konut hizmet kamu',
            'su' => 'konut hizmet kamu',
            
            // 👮‍♂️ POLİS & KAMU
            'gbt' => 'kolluk hürriyet güvenlik kimlik',
            'bekletilme' => 'kolluk hürriyet idare',
            'karakol' => 'kolluk yargı adalet',
            
            // 💼 İŞ & ÇALIŞMA
            'tazminat' => 'is calisma ekonomik alacak',
            'mobbing' => 'calisma eziyet onur haysiyet',
            'sgk' => 'sosyal guvenlik calisma devlet',
            'prim' => 'is calisma ucret ekonomik',
            
            // 🛒 TÜKETİCİ
            'bilgisayar' => 'tüketici ürün mal ticaret',
            'indirim' => 'tüketici aldatıcı reklam ticaret',
            'garanti' => 'tüketici guvence sozlesme',
            'kargo' => 'tüketici lojistik mulkiyet',
            
            // 🚗 TRAFİK & ULAŞIM
            'radar' => 'trafik ceza idare idari islem',
            'plaka' => 'trafik ceza idare',
            'kusur' => 'trafik kaza sigorta hukuk',
            'sigorta' => 'mulkiyet borç alacak kaza',
            'çekici' => 'trafik mülkiyet idare',
            
            // 🏥 SAĞLIK
            'ameliyat' => 'saglik vucut butunlugu yasam',
            'doktor' => 'saglik hizmet hekim',
            'teşhis' => 'saglik malpraktis kusur',
            'hata' => 'saglik malpraktis tazminat',
            
            // 🎓 EĞİTİM
            'okul' => 'egitim ogretim devlet',
            'diploma' => 'egitim belge idari',
            'sınav' => 'egitim adalet idare',
            'staj' => 'egitim is calisma',
            
            // 💰 MALİ & BORÇ
            'haciz' => 'mulkiyet borç icra ekonomik',
            'maaş kesintisi' => 'mulkiyet ucret ekonomik',
            'senet' => 'borç alacak mulkiyet',
            'kredi' => 'banka ekonomik borç',
            
            // 👪 AİLE
            'şiddet' => 'aile koruma vucut butunlugu',
            'nafaka' => 'aile ekonomik borç',
            'velayet' => 'aile çocuk hak',
            
            // 🏛️ İDARE & YARGI
            'belediye' => 'idare devlet yerel',
            'imar' => 'mulkiyet idare devlet',
            'ruhsat' => 'idare ticaret izin',
            'dava' => 'yargı adalet mahkeme',
            'savcı' => 'yargı adalet ceza',
            'hakim' => 'yargı adalet karar'
        ];

        foreach ($mapping as $key => $legalTerms) {
            if (mb_strpos($text, $key) !== false) {
                $text .= " " . $legalTerms;
            }
        }

        return $text;
    }

    protected function extractKeywords(string $text): array
    {
        $stopWords = [
            'bir', 'bu', 'şu', 'o', 've', 'ile', 'için', 'gibi', 'kadar', 'daha', 'çok', 'az', 'en', 'da', 'de', 'ki', 'mi', 'mu', 'mü', 'var', 'yok', 
            'ama', 'fakat', 'ancak', 'lakin', 'yani', 'zira', 'çünkü', 'oysa', 'halbu ki',
            'dedi', 'dediler', 'söyledi', 'söylediler', 'dedim', 'dedik', 'etti', 'ettiler', 'yaptı', 'yaptılar', 'oldu', 'oldular', 'bunun', 'şunun', 'onun', 
            'amaç', 'filan', 'falan', 'şöyle', 'böyle', 'onlar', 'bizim', 'sizin', 'şeyi', 'şeye'
        ];
        
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return mb_strlen($word) >= 2 && !in_array($word, $stopWords);
        });
        return array_values(array_unique($keywords));
    }

    protected function detectRightCategories(array $keywords, string $fullText): array
    {
        $categories = RightCategory::active()->ordered()->get();
        $results = [];

        foreach ($categories as $category) {
            $score = 0;
            $reasons = [];
            $catKeywords = $category->keywords ?? [];

            foreach ($keywords as $kw) {
                $matchFound = false;
                foreach ($catKeywords as $ckw) {
                    if (mb_strpos($kw, $ckw) !== false || mb_strpos($ckw, $kw) !== false) {
                        $score += 35;
                        $matchFound = true;
                    }
                }
                if ($matchFound && count($reasons) < 1) {
                    $reasons[] = "Olaydaki '" . $kw . "' kavramı " . $category->name . " alanıyla doğrudan ilişkili.";
                }
            }

            // V10: Özel Senaryo Puanlamaları
            if ($category->slug === 'tuketici-haklari' && (mb_strpos($fullText, 'bozuk') !== false || mb_strpos($fullText, 'iade') !== false)) $score += 50;
            if ($category->slug === 'trafik-ulasim' && (mb_strpos($fullText, 'radar') !== false || mb_strpos($fullText, 'ceza') !== false)) $score += 50;
            if ($category->slug === 'is-calisma' && (mb_strpos($fullText, 'maaş') !== false || mb_strpos($fullText, 'kov') !== false)) $score += 50;
            if ($category->slug === 'saglik-haklari' && (mb_strpos($fullText, 'ameliyat') !== false || mb_strpos($fullText, 'hata') !== false)) $score += 50;
            if ($category->slug === 'aile-hukuku' && (mb_strpos($fullText, 'şiddet') !== false || mb_strpos($fullText, 'nafaka') !== false)) $score += 50;

            if ($score > 0) {
                $results[] = [
                    'category' => $category,
                    'score' => min($score, 100),
                    'reasons' => array_unique($reasons)
                ];
            }
        }

        if (empty($results)) {
            $genel = RightCategory::where('slug', 'devlet-ilkeleri')->first();
            if ($genel) $results[] = ['category' => $genel, 'score' => 10, 'reasons' => ["Genel hukuk ilkeleri."]];
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        return array_slice($results, 0, 5);
    }

    /**
     * V10.0: The Final Omni-Guide (Universal Scenarios)
     */
    protected function getVirtualGuide(string $slug, array $keywords, string $fullText): ?string
    {
        // 🏥 Sağlık Hakları
        if (mb_strpos($fullText, 'ameliyat') !== false || mb_strpos($fullText, 'hata') !== false || mb_strpos($fullText, 'doktor') !== false) {
            return "SAĞLIK HAKLARI REHBERİ:\n1. Tıbbi hata (malpraktis) şüphesinde hasta hakları birimine başvurun.\n2. Tüm rapor ve epikriz belgelerinizin bir örneğini alın.\n3. Maddi ve manevi tazminat davası için bir sağlık hukuku uzmanı ile görüşün.";
        }

        // 🚗 Trafik & Ulaşım
        if (mb_strpos($fullText, 'trafik') !== false || mb_strpos($fullText, 'ceza') !== false || mb_strpos($fullText, 'radar') !== false) {
            return "TRAFİK HUKUKU REHBERİ:\n1. Trafik cezalarına itiraz süresi 15 gündür. Sulh Ceza Hakimliğine başvurun.\n2. Kaza sonrası araç değer kaybı tazminatı için 2 yıl içinde sigorta şirketine başvuru hakkınız vardır.\n3. Kusur oranına itiraz için kaza yerini fotoğraflayın.";
        }

        // 👪 Aile Hukuku
        if (mb_strpos($fullText, 'şiddet') !== false || mb_strpos($fullText, 'nafaka') !== false || mb_strpos($fullText, 'velayet') !== false) {
            return "AİLE HUKUKU REHBERİ:\n1. Şiddet durumunda KADES uygulamasını kullanın veya 183'ü arayın. 6284 sayılı Kanun sizi korur.\n2. Nafaka ödenmemesi durumunda icra takibi başlatılabilir.\n3. Çocuğun üstün yararı velayet davalarında temel ilkedir.";
        }

        // 🛒 Tüketici Hakları
        if (mb_strpos($fullText, 'bozuk') !== false || mb_strpos($fullText, 'bilgisayar') !== false || mb_strpos($fullText, 'iade') !== false) {
            return "TÜKETİCİ HAKLARI REHBERİ:\n1. Ayıplı malda 6 ay içinde ispat yükü satıcıdadır. \n2. Değişim veya para iadesi seçme hakkınız vardır.\n3. THH'ye (Tüketici Hakem Heyeti) E-devlet üzerinden online olarak başvurabilirsiniz.";
        }

        // 🏙️ İdare & Belediye
        if (mb_strpos($fullText, 'belediye') !== false || mb_strpos($fullText, 'yol') !== false || mb_strpos($fullText, 'imar') !== false) {
            return "İDARE HUKUKU REHBERİ:\n1. İdari işlemlere karşı 60 gün içinde İdare Mahkemesi'nde iptal davası açılabilir.\n2. Hizmet kusuru nedeniyle oluşan zararlar için tam yargı davası açma hakkınız vardır.\n3. Bilgi edinme yasasıyla her türlü işlem hakkında bilgi isteyebilirsiniz.";
        }

        // 💼 İş Hukuku
        if (mb_strpos($fullText, 'maaş') !== false || mb_strpos($fullText, 'işten') !== false) {
            return "İŞ GÜVENCESİ REHBERİ:\n1. Haksız çıkarma durumunda işe iade davası açılabilir (Arabulucu şart).\n2. Fazla mesai ve tazminat haklarınız için tanık ve belge (bordro) önemlidir.\n3. SGK primlerinizi e-devletten düzenli kontrol edin.";
        }

        return null; 
    }

    protected function findRelevantArticles(array $keywords, array $rightCategories, string $fullText): array
    {
        $matched = [];
        foreach ($rightCategories as $catInfo) {
            $cat = $catInfo['category'];
            $articles = $cat->constitutionArticles()->active()->get();

            foreach ($articles as $article) {
                $score = $catInfo['score'] * 0.7;
                $reasons = ["'" . $cat->name . "' kategorisindeki temel hak güvencesidir."];

                $kwStr = is_array($article->keywords) ? implode(' ', $article->keywords) : (string)$article->keywords;
                $artText = mb_strtolower($article->official_text . ' ' . $kwStr . ' ' . $article->title, 'UTF-8');
                
                $hits = 0;
                foreach ($keywords as $kw) {
                    if (mb_strpos($artText, $kw) !== false) $hits++;
                }

                if ($hits > 0) {
                    $score += ($hits * 15);
                    $reasons[] = "Metindeki bağlam ile anayasanın bu maddesi arasında $hits adet teknik temas saptandı.";
                }

                if (isset($matched[$article->id])) {
                    $matched[$article->id]['score'] += 20;
                    $matched[$article->id]['reasons'] = array_merge($matched[$article->id]['reasons'], $reasons);
                } else {
                    $matched[$article->id] = ['article' => $article, 'score' => $score, 'reasons' => $reasons];
                }
            }
        }

        $fallbacks = [2, 10, 36, 35, 40];
        foreach ($fallbacks as $num) {
            $art = ConstitutionArticle::where('article_number', $num)->first();
            if ($art && !isset($matched[$art->id])) {
                $matched[$art->id] = ['article' => $art, 'score' => 5, 'reasons' => ["Hukuk devleti temel güvencelerindendir."]];
            }
        }

        usort($matched, fn($a, $b) => $b['score'] <=> $a['score']);
        return array_slice($matched, 0, 10);
    }

    protected function getSupportingLaws(array $articles): array
    {
        $laws = [];
        foreach ($articles as $item) {
            $supp = SupportingLaw::where('constitution_article_id', $item['article']->id)->active()->get();
            if ($supp->isNotEmpty()) {
                $laws[] = ['article' => $item['article'], 'laws' => $supp];
            }
        }
        return $laws;
    }

    protected function formatAnalysisResult($eventDescription, $keywords, $rightCategories, $constitutionArticles, $supportingLaws): array
    {
        return [
            'event_description' => $eventDescription,
            'detected_keywords' => $keywords,
            'right_categories' => array_map(function($item) use ($keywords, $eventDescription) {
                $virtualGuide = $this->getVirtualGuide($item['category']->slug, $keywords, $eventDescription);
                return [
                    'id' => $item['category']->id,
                    'name' => $item['category']->name,
                    'description' => $item['category']->description,
                    'detailed_guide' => $virtualGuide ?? $item['category']->detailed_guide,
                    'score' => round($item['score']),
                    'reasons' => array_unique($item['reasons'])
                ];
            }, $rightCategories),
            'constitution_articles' => array_map(function($item) {
                return [
                    'id' => $item['article']->id,
                    'article_number' => $item['article']->article_number,
                    'title' => $item['article']->title,
                    'official_text' => $item['article']->official_text,
                    'simplified_explanation' => $item['article']->simplified_explanation,
                    'score' => round($item['score']),
                    'reasons' => array_unique($item['reasons'])
                ];
            }, $constitutionArticles),
            'supporting_laws' => $supportingLaws,
            'analysis_date' => now()->format('d.m.Y H:i'),
        ];
    }

    public function saveEventRecord(string $description, array $result, ?string $sid = null): EventRecord
    {
        return EventRecord::create([
            'event_description' => $description,
            'detected_keywords' => $result['detected_keywords'],
            'detected_right_categories' => array_map(fn($c) => $c['id'], $result['right_categories']),
            'matched_articles' => array_map(fn($a) => $a['id'], $result['constitution_articles']),
            'ip_address' => request()->ip(),
            'session_id' => $sid ?? session()->getId(),
            'analyzed_at' => now(),
        ]);
    }
}
