<?php

namespace Database\Seeders;

use App\Models\Journalist;
use App\Models\NewsType;
use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OPovoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Journalist::factory()->count(3)->create();

        $journalist1 = Journalist::factory()->create();
        NewsType::factory()->count(3)->for($journalist1)->create();

        $journalist2 = Journalist::factory()->create();
        $newstype2 = NewsType::factory()->for($journalist2)->create();
        News::factory()->count(3)->for($journalist2)->for($newstype2)->create();
    }
}
