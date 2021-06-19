<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MentorCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            ['name' => 'Movie', 'value' => 'movie'],
            ['name' => 'Music', 'value' => 'music'],
            ['name' => 'Comedy', 'value' => 'comedy'],
            ['name' => 'Fashion', 'value' => 'fashion'],
        ];

        foreach ($cats as $cat) {
            \App\Models\MentorCategory::create($cat);
        }
    }
}
