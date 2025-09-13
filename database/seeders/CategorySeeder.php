<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\CategoryType;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    public function run(): void
    {   
        Category::truncate();

        //PORTFOLIO

        $interior = Category::create([
            'name' => 'Nội thất',
            'slug' => Str::slug('Nội thất'),
            'type' => CategoryType::PORTFOLIO,
        ]);

        $villa = Category::create([
            'name' => 'Biệt thự',
            'slug' => Str::slug('Biệt Thự'),
            'type' => CategoryType::PORTFOLIO,
        ]);

        $townhouse = Category::create([
            'name' => 'Nhà phố',
            'slug' => Str::slug('Nhà phố'),
            'type' => CategoryType::PORTFOLIO,
        ]);

        $commercial = Category::create([
            'name' => 'Nhà thương mại',
            'slug' => Str::slug('Nhà thương mại'),
            'type' => CategoryType::PORTFOLIO,
        ]);

        // Child categories (PORTFOLIO)
        Category::insert([
            [
                'name' => 'Hiện đại',
                'slug' => Str::slug('Hiện đại'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $interior->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đông Dương',
                'slug' => Str::slug('Đông Dương'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $interior->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rustic',
                'slug' => Str::slug('Rustic'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $interior->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'name' => '2 tầng',
                'slug' => Str::slug('2 tầng'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $townhouse->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '3 tầng',
                'slug' => Str::slug('3 tầng'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $townhouse->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '4 đến 8 tầng',
                'slug' => Str::slug('4 đến 8 tầng'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $townhouse->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nhà cấp 4',
                'slug' => Str::slug('Nhà cấp 4'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $townhouse->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Homestay',
                'slug' => Str::slug('Homestay'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $commercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Văn phòng',
                'slug' => Str::slug('Văn phòng'),
                'type' => CategoryType::PORTFOLIO,
                'parent_id' => $commercial->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Articles
        Category::create([
            'name' => 'Đời sống An Phú',
            'slug' => 'doi-song-an-phu',
            'type' => CategoryType::ARTICLE,
        ]);

        Category::create([
            'name' => 'Sự kiện',
            'slug' => 'su-kien',
            'type' => CategoryType::ARTICLE,
        ]);

        Category::create([
            'name' => 'Công trình',
            'slug' => 'cong-trinh',
            'type' => CategoryType::ARTICLE,
        ]);

    }
}
