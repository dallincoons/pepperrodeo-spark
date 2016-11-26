<?php

use App\Entities\Recipe;
use App\Entities\Item;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class GroceryListManagerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @group grocery-list-manager-test
     * @return void
     * @test
     */
    public function add_recipe()
    {
        $recipe = $this->createRecipe();


    }

    private function createRecipe()
    {
        $recipe = factory(Recipe::class)->create();
        $item = factory(Item::class, 15)->create();

        $recipe->items()->saveMany($item);

        return $recipe;
    }
}
