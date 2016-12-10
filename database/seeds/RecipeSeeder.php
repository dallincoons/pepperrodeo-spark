<?php

use Illuminate\Database\Seeder;
use App\Entities\Recipe;
use App\Entities\Item;
use App\Entities\RecipeCategory;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 8) as $index){

            $recipe = Recipe::create([
                'user_id' => 1,
                'title' => $faker->word,
                'directions' => $faker->paragraph,
                'recipe_category_id' => RecipeCategory::inRandomOrder()->get()->first()->getKey()
            ]);

            foreach(range(1, 9) as $itemindex)
            {
                $item = factory(Item::class)->create();
                $recipe->items()->save($item);
            }
        }
    }
}
