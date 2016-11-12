<?php

use Illuminate\Database\Seeder;
use App\RecipeCategory;

class RecipeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $names = [
            'Favorites',
            'Want to Try',
            'Crockpot',
            'Fresh veggies',
        ];

        foreach($names as $name){

            RecipeCategory::create([
                'user_id' => 1,
                'name' => $name
            ]);
        }

    }
}
