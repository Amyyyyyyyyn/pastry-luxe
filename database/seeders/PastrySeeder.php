<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PastrySeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Caramella Sweets Admin',
            'password' => Hash::make('Password123!'),
            'is_admin' => true,
        ]);

        $cats = [
            ['name' => 'Cakes', 'slug' => 'cakes', 'excerpt' => 'Signature cakes', 'sort_order' => 1],
            ['name' => 'Cupcakes', 'slug' => 'cupcakes', 'excerpt' => 'Soft and creamy', 'sort_order' => 2],
            ['name' => 'Donuts', 'slug' => 'donuts', 'excerpt' => 'Glazed donuts', 'sort_order' => 3],
            ['name' => 'Biscuits', 'slug' => 'biscuits', 'excerpt' => 'Crispy biscuits', 'sort_order' => 4],
        ];
        foreach ($cats as $c) Category::updateOrCreate(['slug' => $c['slug']], $c);

        foreach (Category::all() as $category) {
            for ($i = 1; $i <= 3; $i++) {
                Product::updateOrCreate(
                    ['slug' => $category->slug.'-'.$i],
                    [
                        'category_id' => $category->id,
                        'name' => Str::title($category->name).' '.$i,
                        'description' => 'Fresh premium pastry prepared daily.',
                        'price' => rand(30, 120) / 2,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
