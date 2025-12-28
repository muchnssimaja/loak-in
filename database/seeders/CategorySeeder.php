<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
            ],
            [
                'name' => 'Handphone & Gadget',
                'slug' => 'hp-gadget',
            ],
            [
                'name' => 'Laptop & Komputer',
                'slug' => 'laptop-komputer',
            ],
            [
                'name' => 'Perabot & Rumah Tangga',
                'slug' => 'perabot',
            ],
            [
                'name' => 'Fashion & Aksesoris',
                'slug' => 'fashion',
            ],
            [
                'name' => 'Hobi & Koleksi',
                'slug' => 'hobi-koleksi',
            ],
            [
                'name' => 'Sepeda & Aksesoris',
                'slug' => 'sepeda',
            ],
            [
                'name' => 'Bayi & Anak',
                'slug' => 'bayi-anak',
            ],
            [
                'name' => 'Peralatan Kantor & Sekolah',
                'slug' => 'kantor-sekolah',
            ],
            [
                'name' => 'Lainnya',
                'slug' => 'lainnya',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }
    }
}
