<?php

namespace Database\Seeders;

use App\Models\RightCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RightCategorySeeder extends Seeder
{

    public function run(): void
    {
        $categories=[
            [
                'name'=>'Kişi Özgürlüğü ve Güvenliği',
                'description'=>'Kişinin beden bütünlüğü,özgürlüğü ve güvenliği ile ilgili haklar',
                'keywords' => ['tutuklama', 'gözaltı', 'yakalama', 'arama', 'kişi özgürlüğü', 'güvenlik', 'beden', 'tutuklu', 'mahkum', 'cezaevi', 'hapis'],
                'order'=>1,
            ],
            [
                'name'=>'Özel Hayatın Gizliliği',
                'description'=>'Özel hayat,konut dokunulmazlığı ve haberleşme özgürlüğü',
                'keywords' => ['özel hayat', 'gizlilik', 'konut', 'ev', 'arama', 'dinleme', 'kayıt', 'haberleşme', 'telefon', 'mesaj', 'e-posta', 'iletişim'],
                'order'=>2
            ],
            [
                'name'=>'Düşünce ve ifade Özgürlüğü',
                'description'=>'Düşünce kaanat,ifade ve basın özgürlüğü',
                'keywords' => ['düşünce', 'ifade', 'basın', 'medya', 'gazete', 'tv', 'internet', 'sosyal medya', 'yayın', 'yazı', 'konuşma', 'eleştiri'],
                'order'=>3,
            ],
            [
                'name'=>'Toplatı ve Gösteri Özgürlüğü',
                'description'=>'Toplatı, gösteri yürüyüşü ve dernek kurma özgürlüğü',
                'keywords' => ['toplantı', 'gösteri', 'yürüyüş', 'miting', 'protesto', 'dernek', 'sendika', 'örgüt', 'toplanma'],
                'order'=>4,
            ],
            [
                'name'=>'Mülkiyet Hakkı',
                'description'=>'Mülkiyet hakkı, kamulaştırma ve tazminat',
                                'keywords' => ['mülkiyet', 'taşınmaz', 'arazi', 'ev', 'arsa', 'kamulaştırma', 'istimlak', 'tazminat', 'mal', 'sahiplik'],

                'order'=>
            ]

        ]
    }
}
