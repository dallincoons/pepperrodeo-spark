<?php

use App\Entities\GroceryList;
use App\Entities\Item;
use App\Entities\Recipe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListRecipeTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;


    /**
     * @group recipe-list-tests
     *
     * @test
     */
    public function adds_a_recipe_to_a_grocery_list()
    {
        $grocerylist = factory(GroceryList::class)->create();
        $recipes = factory(Recipe::class, 2)->create();

        $item1 = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();

        $recipes->first()->items()->save($item1);
        $recipes->last()->items()->save($item2);

        $this->post('/grocerylist/' . $grocerylist->getKey() .'/add/', ['recipes' => $recipes->pluck('id')]);

        $this->assertEquals(2, $grocerylist->fresh()->items->count());
    }

    /**
     * @group recipe-list-tests
     *
     * @test
     */
    public function skips_dupicate_recipe_when_adding_to_grocery_list()
    {
        /* @var GroceryList $grocerylist */
        $grocerylist = factory(GroceryList::class)->create();
        $recipes = factory(Recipe::class, 2)->create();

        $item1 = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();

        $recipes->first()->items()->save($item1);
        $recipes->last()->items()->save($item2);

        $grocerylist->addRecipes($recipes);

        $response = $this->post('/grocerylist/' . $grocerylist->getKey() .'/add', ['grocerylist' => $grocerylist->getKey(), 'recipes' => $recipes->pluck('id')]);

        $response->assertStatus(200);

        $this->assertEquals(2, $grocerylist->fresh()->items->count());
    }
}
