<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Array of categories data
        $categories = [
            [
                'id' => 1,
                'name' => 'Electronics',
                'category_id' => NULL
            ],
            [
                'id' => 2,
                'name' => 'Computers',
                'category_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'Mobile Phones',
                'category_id' => 1
            ],
            [
                'id' => 4,
                'name' => 'Clothing',
                'category_id' => NULL
            ],
            [
                'id' => 5,
                'name' => 'Men Clothing',
                'category_id' => 4
            ],
            [
                'id' => 6,
                'name' => 'Women Clothing',
                'category_id' => 4
            ],
            [
                'id' => 7,
                'name' => 'Home Appliances',
                'category_id' => NULL
            ],
            [
                'id' => 8,
                'name' => 'Kitchen Appliances',
                'category_id' => 7
            ],
            [
                'id' => 9,
                'name' => 'Bedroom Appliances',
                'category_id' => 7
            ],
            [
                'id' => 10,
                'name' => 'Sports and Outdoors',
                'category_id' => NULL
            ],
            [
                'id' => 11,
                'name' => 'Outdoor Gear',
                'category_id' => 10
            ],
            [
                'id' => 12,
                'name' => 'Fitness Equipment',
                'category_id' => 10
            ],
            [
                'id' => 13,
                'name' => 'Beauty and Personal Care',
                'category_id' => NULL
            ],
            [
                'id' => 14,
                'name' => 'Skincare',
                'category_id' => 13
            ],
            [
                'id' => 15,
                'name' => 'Makeup',
                'category_id' => 13
            ]
        ];
        foreach ($categories as $category) {
            Category::updateOrCreate([
                'id' => $category['id'],
            ], $category);
        }
    }
}
