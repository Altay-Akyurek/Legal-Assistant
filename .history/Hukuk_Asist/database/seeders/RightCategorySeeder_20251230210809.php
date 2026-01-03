<?php

namespace Database\Seeders;

use App\Models\RightCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Hak Kategorileri Seeder
 * Temel hak ve özgürlükler kategorileri
 */
class RightCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kişi Özgürlüğü ve Güvenliği',
                'description' => 'Kişinin beden bütünlüğü, özgürlüğü ve güvenliği ile ilgili haklar',
                'keywords' => ['tutuklama', 'gözaltı', 'yakalama', 'arama', 'kişi özgürlüğü', 'güvenlik', 'beden', 'tutuklu', 'mahkum', 'cezaevi', 'hapis'],
                'order' => 1,
            ],
            [
                'name' => 'Özel Hayatın Gizliliği',
                'description' => 'Özel hayat, konut dokunulmazlığı ve haberleşme özgürlüğü',
                'keywords' => ['özel hayat', 'gizlilik', 'konut', 'ev', 'arama', 'dinleme', 'kayıt', 'haberleşme', 'telefon', 'mesaj', 'e-posta', 'iletişim'],
                'order' => 2,
            ],
            [
                'name' => 'Düşünce ve İfade Özgürlüğü',
                'description' => 'Düşünce, kanaat, ifade ve basın özgürlüğü',
                'keywords' => ['düşünce', 'ifade', 'basın', 'medya', 'gazete', 'tv', 'internet', 'sosyal medya', 'yayın', 'yazı', 'konuşma', 'eleştiri'],
                'order' => 3,
            ],
            [
                'name' => 'Toplantı ve Gösteri Özgürlüğü',
                'description' => 'Toplantı, gösteri yürüyüşü ve dernek kurma özgürlüğü',
                'keywords' => ['toplantı', 'gösteri', 'yürüyüş', 'miting', 'protesto', 'dernek', 'sendika', 'örgüt', 'toplanma'],
                'order' => 4,
            ],
            [
                'name' => 'Mülkiyet Hakkı',
                'description' => 'Mülkiyet hakkı, kamulaştırma ve tazminat',
                'keywords' => ['mülkiyet', 'taşınmaz', 'arazi', 'ev', 'arsa', 'kamulaştırma', 'istimlak', 'tazminat', 'mal', 'sahiplik'],
                'order' => 5,
            ],
            [
                'name' => 'Çalışma ve Sosyal Haklar',
                'description' => 'Çalışma hakkı, sendika, grev, sosyal güvenlik',
                'keywords' => ['çalışma', 'iş', 'işçi', 'memur', 'sendika', 'grev', 'sosyal güvenlik', 'emekli', 'maaş', 'ücret', 'tatil', 'izin'],
                'order' => 6,
            ],
            [
                'name' => 'Eğitim Hakkı',
                'description' => 'Eğitim ve öğrenim hakkı',
                'keywords' => ['eğitim', 'öğrenim', 'okul', 'üniversite', 'öğrenci', 'öğretmen', 'ders', 'sınav', 'diploma'],
                'order' => 7,
            ],
            [
                'name' => 'Sağlık Hakkı',
                'description' => 'Sağlık hizmetlerinden yararlanma hakkı',
                'keywords' => ['sağlık', 'hastane', 'doktor', 'tedavi', 'ilaç', 'hasta', 'sağlık hizmeti', 'muayene'],
                'order' => 8,
            ],
            [
                'name' => 'Adil Yargılanma Hakkı',
                'description' => 'Adil yargılanma, savunma hakkı ve yargı bağımsızlığı',
                'keywords' => ['yargı', 'mahkeme', 'dava', 'hakim', 'savcı', 'avukat', 'savunma', 'adil yargılanma', 'ceza', 'hukuk'],
                'order' => 9,
            ],
            [
                'name' => 'Tüketici Hakları',
                'description' => 'Tüketici hakları ve korunması',
                'keywords' => ['tüketici', 'satın alma', 'ürün', 'hizmet', 'garanti', 'iade', 'değişim', 'tüketici hakları'],
                'order' => 10,
            ],
            [
                'name' => 'İdari İşlemler',
                'description' => 'İdari kararlar, başvurular ve idari yargı',
                'keywords' => ['idare', 'kamu', 'kurum', 'başvuru', 'karar', 'izin', 'ruhsat', 'belge', 'idari işlem'],
                'order' => 11,
            ],
            [
                'name' => 'Kolluk İşlemleri',
                'description' => 'Polis, jandarma ve güvenlik güçlerinin işlemleri',
                'keywords' => ['polis', 'jandarma', 'kolluk', 'güvenlik', 'soruşturma', 'ifade', 'tanık', 'şüpheli'],
                'order' => 12,
            ],
        ];

        foreach ($categories as $category) {
            RightCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'keywords' => $category['keywords'],
                'order' => $category['order'],
                'is_active' => true,
            ]);
        }
    }
}
