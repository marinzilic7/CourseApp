<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->name="Web Development";
        $category->save();

        $category1 = new Category();
        $category1->name="Web Design";
        $category1->save();

        $category2 = new Category();
        $category2->name="Excel";
        $category2->save();

        $category3 = new Category();
        $category3->name="Marketing";
        $category3->save();
    }
}
