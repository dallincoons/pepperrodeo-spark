<?php

use App\Entities\GroceryList;
use App\Entities\Item;
use App\Entities\Recipe;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroceryListRecipesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @group list-recipe-tests
     *
     * @test
     */
    public function adds_recipe_to_existing_grocery_list()
    {
        $this->disableExceptionHandling();

        $recipe = factory(Recipe::class)->create();
        $items = factory(Item::class, 3)->create();
        $recipe->items()->saveMany($items);

        $grocerylist = factory(GroceryList::class)->create();

        $this->assertCount(0, $grocerylist->items);

        $response = $this->post('/grocerylist/' . $grocerylist->getKey() . '/recipe', ['recipes' => [$recipe->getKey()]]);

        $response->assertStatus(200);
        $this->assertCount($recipe->items->count(), $grocerylist->fresh()->items);
    }
}
