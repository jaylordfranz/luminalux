<?php

use Illuminate\database\seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::factory()->count(10)->create();
    }
}
