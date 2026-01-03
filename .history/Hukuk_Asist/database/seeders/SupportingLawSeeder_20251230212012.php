<?php

namespace Database\Seeders;

use App\Models\ConstitutionArticle;
use App\Models\SupportingLaw;
use Illuminate\Database\Seeder;

/**
 * Destekleyici Kanunlar Seeder
 * Anayasa maddelerini destekleyen kanunlar (bilgilendirme amaçlı)
 */
class SupportingLawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Örnek destekleyici kanunlar
        $laws = [
            [
                'article_number' => 17,
                'laws' => [
                    [
                        'law_name' => 'Ceza Muhakemesi Kanunu',
                        'law_number' => '5271',
                        'relevant_articles' => 'Madde 90-91 (Yakalama), Madde 100-101 (Tutuklama)',
                        'description' => 'Kişi özgürlüğü ve güvenliği ile ilgili ceza muhakemesi usulleri',
                        'keywords' => ['tutuklama', 'yakalama', 'gözaltı', 'ceza muhakemesi'],
                    ],
                ],
            ],
            [
                'article_number' => 21,
                'laws' => [
                    [
                        'law_name' => 'Ceza Muhakemesi Kanunu',
                        'law_number' => '5271',
                        'relevant_articles' => 'Madde 116-120 (Arama)',
                        'description' => 'Konut dokunulmazlığı ve arama işlemleri',
                        'keywords' => ['arama', 'konut', 'ev', 'dokunulmazlık'],
                    ],
                ],
            ],
            [
                'article_number' => 22,
                'laws' => [
                    [
                        'law_name' => 'Ceza Muhakemesi Kanunu',
                        'law_number' => '5271',
                        'relevant_articles' => 'Madde 134-140 (İletişimin Tespiti, Dinleme ve Kayda Alma)',
                        'description' => 'Haberleşme özgürlüğü ve gizliliği',
                        'keywords' => ['dinleme', 'kayıt', 'iletişim', 'haberleşme'],
                    ],
                ],
            ],
            [
                'article_number' => 26,
                'laws' => [
                    [
                        'law_name' => 'Türk Ceza Kanunu',
                        'law_number' => '5237',
                        'relevant_articles' => 'Madde 125 (Hakaret), Madde 299 (Cumhurbaşkanına Hakaret)',
                        'description' => 'İfade özgürlüğünün sınırları',
                        'keywords' => ['ifade', 'hakaret', 'özgürlük', 'sınır'],
                    ],
                ],
            ],
            [
                'article_number' => 35,
                'laws' => [
                    [
                        'law_name' => 'Kamulaştırma Kanunu',
                        'law_number' => '2942',
                        'relevant_articles' => 'Genel Hükümler',
                        'description' => 'Mülkiyet hakkı ve kamulaştırma işlemleri',
                        'keywords' => ['kamulaştırma', 'istimlak', 'mülkiyet', 'tazminat'],
                    ],
                ],
            ],
            [
                'article_number' => 36,
                'laws' => [
                    [
                        'law_name' => 'İş Kanunu',
                        'law_number' => '4857',
                        'relevant_articles' => 'Genel Hükümler',
                        'description' => 'Çalışma hakkı ve iş ilişkileri',
                        'keywords' => ['iş', 'çalışma', 'işçi', 'işveren', 'sözleşme'],
                    ],
                ],
            ],
        ];

        foreach ($laws as $lawData) {
            $article = ConstitutionArticle::where('article_number', $lawData['article_number'])->first();

            if ($article && isset($lawData['laws'])) {
                foreach ($lawData['laws'] as $law) {
                    SupportingLaw::create([
                        'constitution_article_id' => $article->id,
                        'law_name' => $law['law_name'],
                        'law_number' => $law['law_number'],
                        'relevant_articles' => $law['relevant_articles'],
                        'description' => $law['description'],
                        'keywords' => $law['keywords'],
                        'order' => 1,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
