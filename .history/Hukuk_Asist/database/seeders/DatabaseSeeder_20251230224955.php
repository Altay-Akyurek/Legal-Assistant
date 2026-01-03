<?php

namespace Database\Seeders;

use App\Models\RightCategory;
use App\Models\SupportingLaw;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //seeder sırası önemli:önce katogriler,sonra maddeler , sonra kanunlar
        $this->call([
            RightCategorySeeder::class,
            ConstitutionArticleSeeder::class,
            SupportingLawSeeder::class,
        ]);


    }
}
