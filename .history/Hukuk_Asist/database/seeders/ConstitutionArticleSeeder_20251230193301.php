<?php

namespace Database\Seeders;

use App\Models\ConstitutionArticle;
use App\Models\RightCategory;
use Illuminate\Database\Seeder;

/**
 * Anayasa Maddeleri Seeder
 * Türkiye Cumhuriyeti Anayasası örnek maddeleri
 */
class ConstitutionArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Örnek anayasa maddeleri (gerçek anayasa maddelerinden uyarlanmış)
        $articles = [
            [
                'article_number' => 17,
                'title' => 'Kişi Özgürlüğü ve Güvenliği',
                'official_text' => 'Herkes, yaşama, maddi ve manevi varlığını koruma ve geliştirme hakkına sahiptir. Tıbbi zorunluluklar ve kanunda yazılı haller dışında, kişinin vücut bütünlüğüne dokunulamaz; rızası olmadan bilimsel ve tıbbi deneylere tabi tutulamaz. Kimseye işkence ve eziyet yapılamaz; kimse insan haysiyetiyle bağdaşmayan bir cezaya veya muameleye tabi tutulamaz.',
                'simplified_explanation' => 'Herkesin yaşama hakkı vardır. Kişinin beden bütünlüğü korunur. İşkence ve kötü muamele yasaktır.',
                'keywords' => ['yaşama', 'beden', 'vücut', 'bütünlük', 'işkence', 'eziyet', 'kişi özgürlüğü', 'güvenlik'],
                'right_category_slugs' => ['kisi-ozgurlugu-ve-guvenligi'],
            ],
            [
                'article_number' => 20,
                'title' => 'Özel Hayatın Gizliliği',
                'official_text' => 'Herkes, özel hayatına ve aile hayatına saygı gösterilmesini isteme hakkına sahiptir. Özel hayatın ve aile hayatının gizliliğine dokunulamaz.',
                'simplified_explanation' => 'Herkesin özel hayatı ve aile hayatı gizlidir. Bu gizliliğe saygı gösterilmelidir.',
                'keywords' => ['özel hayat', 'aile', 'gizlilik', 'mahremiyet'],
                'right_category_slugs' => ['ozel-hayatin-gizliligi'],
            ],
            [
                'article_number' => 21,
                'title' => 'Konut Dokunulmazlığı',
                'official_text' => 'Kimsenin konutuna dokunulamaz. Kanunda gösterilen hallerde, usulüne göre verilmiş hakim kararı olmadıkça; gecikmesinde sakınca bulunan hallerde de kanunla yetkili kılınmış merciin emri bulunmadıkça, kimsenin konutuna girilemez, arama yapılamaz ve buradaki eşyaya el konulamaz.',
                'simplified_explanation' => 'Kimsenin evine izinsiz girilemez. Arama yapılabilmesi için hakim kararı gerekir. Acil durumlarda kanunla yetkili merciin emri yeterlidir.',
                'keywords' => ['konut', 'ev', 'arama', 'dokunulmazlık', 'hakim kararı'],
                'right_category_slugs' => ['ozel-hayatin-gizliligi'],
            ],
            [
                'article_number' => 22,
                'title' => 'Haberleşme Özgürlüğü',
                'official_text' => 'Herkes, haberleşme özgürlüğüne sahiptir. Haberleşmenin gizliliği esastır.',
                'simplified_explanation' => 'Herkes haberleşme özgürlüğüne sahiptir. Haberleşmeler gizlidir.',
                'keywords' => ['haberleşme', 'iletişim', 'gizlilik', 'telefon', 'mesaj', 'e-posta'],
                'right_category_slugs' => ['ozel-hayatin-gizliligi'],
            ],
            [
                'article_number' => 25,
                'title' => 'Düşünce ve Kanaat Özgürlüğü',
                'official_text' => 'Herkes, düşünce ve kanaat özgürlüğüne sahiptir.',
                'simplified_explanation' => 'Herkes düşünce ve kanaat özgürlüğüne sahiptir.',
                'keywords' => ['düşünce', 'kanaat', 'özgürlük', 'fikir'],
                'right_category_slugs' => ['dusunce-ve-ifade-ozgurlugu'],
            ],
            [
                'article_number' => 26,
                'title' => 'Düşünceyi Açıklama ve Yayma Özgürlüğü',
                'official_text' => 'Herkes, düşünce ve kanaatlerini söz, yazı, resim veya başka yollarla tek başına veya toplu olarak açıklama ve yayma hakkına sahiptir.',
                'simplified_explanation' => 'Herkes düşüncelerini açıklama ve yayma hakkına sahiptir.',
                'keywords' => ['düşünce', 'açıklama', 'yayma', 'ifade', 'söz', 'yazı'],
                'right_category_slugs' => ['dusunce-ve-ifade-ozgurlugu'],
            ],
            [
                'article_number' => 28,
                'title' => 'Basın Özgürlüğü',
                'official_text' => 'Basın hürdür, sansür edilemez.',
                'simplified_explanation' => 'Basın özgürdür ve sansür edilemez.',
                'keywords' => ['basın', 'medya', 'gazete', 'yayın', 'sansür', 'özgürlük'],
                'right_category_slugs' => ['dusunce-ve-ifade-ozgurlugu'],
            ],
            [
                'article_number' => 34,
                'title' => 'Toplantı ve Gösteri Yürüyüşü Düzenleme Hakkı',
                'official_text' => 'Herkes, önceden izin almadan, silahsız ve saldırısız toplantı ve gösteri yürüyüşü düzenleme hakkına sahiptir.',
                'simplified_explanation' => 'Herkes izin almadan toplantı ve gösteri yürüyüşü düzenleyebilir. Toplantılar silahsız ve saldırısız olmalıdır.',
                'keywords' => ['toplantı', 'gösteri', 'yürüyüş', 'miting', 'protesto'],
                'right_category_slugs' => ['toplanti-ve-gosteri-ozgurlugu'],
            ],
            [
                'article_number' => 35,
                'title' => 'Mülkiyet Hakkı',
                'official_text' => 'Herkes, mülkiyet ve miras haklarına sahiptir.',
                'simplified_explanation' => 'Herkes mülkiyet ve miras haklarına sahiptir.',
                'keywords' => ['mülkiyet', 'miras', 'mal', 'taşınmaz', 'sahiplik'],
                'right_category_slugs' => ['mulkiyet-hakki'],
            ],
            [
                'article_number' => 36,
                'title' => 'Çalışma ve Sözleşme Özgürlüğü',
                'official_text' => 'Herkes, dilediği alanda çalışma ve sözleşme hürriyetine sahiptir.',
                'simplified_explanation' => 'Herkes istediği alanda çalışma ve sözleşme özgürlüğüne sahiptir.',
                'keywords' => ['çalışma', 'iş', 'sözleşme', 'özgürlük', 'işçi'],
                'right_category_slugs' => ['calisma-ve-sosyal-haklar'],
            ],
            [
                'article_number' => 42,
                'title' => 'Eğitim ve Öğrenim Hakkı',
                'official_text' => 'Kimse, eğitim ve öğrenim hakkından yoksun bırakılamaz.',
                'simplified_explanation' => 'Herkes eğitim ve öğrenim hakkına sahiptir.',
                'keywords' => ['eğitim', 'öğrenim', 'okul', 'üniversite', 'öğrenci'],
                'right_category_slugs' => ['egitim-hakki'],
            ],
            [
                'article_number' => 56,
                'title' => 'Sağlık Hizmetleri ve Çevrenin Korunması',
                'official_text' => 'Herkes, sağlıklı ve dengeli bir çevrede yaşama hakkına sahiptir.',
                'simplified_explanation' => 'Herkes sağlıklı bir çevrede yaşama hakkına sahiptir.',
                'keywords' => ['sağlık', 'çevre', 'sağlıklı', 'dengeli'],
                'right_category_slugs' => ['saglik-hakki'],
            ],
        ];

        foreach ($articles as $articleData) {
            $article = ConstitutionArticle::create([
                'article_number' => $articleData['article_number'],
                'title' => $articleData['title'],
                'official_text' => $articleData['official_text'],
                'simplified_explanation' => $articleData['simplified_explanation'],
                'keywords' => $articleData['keywords'],
                'order' => $articleData['article_number'],
                'is_active' => true,
            ]);

            // Hak kategorileri ile ilişkilendir
            if (isset($articleData['right_category_slugs'])) {
                foreach ($articleData['right_category_slugs'] as $slug) {
                    $category = RightCategory::where('slug', $slug)->first();
                    if ($category) {
                        $article->rightCategories()->attach($category->id, [
                            'relevance_score' => 100,
                        ]);
                    }
                }
            }
        }
    }
}
