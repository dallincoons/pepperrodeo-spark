<?php

use App\Entities\Recipe;
use Illuminate\Database\Seeder;
use App\Entities\GroceryList;
use App\Entities\Item;

class GroceryListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 4) as $index){
            $grocerylist = GroceryList::create([
                'user_id' => 1,
                'title' => $faker->word
            ]);

            $recipe = factory(Recipe::class)->create();

            foreach(range(1, 9) as $itemindex)
            {
                $item = factory(Item::class)->create();
                $recipe->items()->save($item);
            }

            $grocerylist->addRecipe($recipe);

        }
    }
}
