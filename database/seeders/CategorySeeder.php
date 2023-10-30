<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                "name" => "Programming",
                "slug" => "programming"
            ],
            [
                "name" => "Design",
                "slug" => "design"
            ],
            [
                "name" => "Travel",
                "slug" => "travel"
            ],
            [
                "name" => "Education",
                "slug" => "education"
            ],
        ]);
    }
}
