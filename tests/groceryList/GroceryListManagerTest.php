<?php

use App\PepperRodeo\GroceryLists\GroceryListManager;
use App\Entities\GroceryList;
use App\Entities\Recipe;
use App\Entities\Item;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroceryListManagerTest extends TestCase
{

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
