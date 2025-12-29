<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConstitutionArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Örnek anayasa maddeleri(gerçek anayasa maddeleri uyarlanmış)
        $articles=[
            'article_number'=>17,
            'title'=>'Kişi Özgürlüğü ve Güvenliği',
            'official_text' => 'Herkes, yaşama, maddi ve manevi varlığını koruma ve geliştirme hakkına sahiptir. Tıbbi zorunluluklar ve kanunda yazılı haller dışında, kişinin vücut bütünlüğüne dokunulamaz; rızası olmadan bilimsel ve tıbbi deneylere tabi tutulamaz. Kimseye işkence ve eziyet yapılamaz; kimse insan haysiyetiyle bağdaşmayan bir cezaya veya muameleye tabi tutulamaz.',
            'simplified_explanation'=>'Herkesin yaşama hakkı vardır.Kişinin beden bütünlüğü korurnur.İşgence ve Kötü muamele yasaktır.',
            'keywords'=>['yaşama','beden','vücut','bütünlük','işgence','eziyet','kişi özgürlüğü','güvenlik'],
            'right_category_slugs'=>['kisi-ozgurlugu-ve-guvenligi'],
        ],
        [
            'article_number'=>20,
            'title'=>'Özel Hayatın Gizliliği',
                'official_text' => 'Herkes, özel hayatına ve aile hayatına saygı gösterilmesini isteme hakkına sahiptir. Özel hayatın ve aile hayatının gizliliğine dokunulamaz.',
        ]
    }
}
