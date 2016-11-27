<?php

use App\Entities\GroceryList;
use App\Entities\Recipe;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RecipeListApiControllerTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    /**
     * @group recipe-list-controller-tests
     * @group api-tests
     *
     * @test
     */
    public function adds_recipe_to_grocery_list()
    {
        $recipe = factory(Recipe::class)->create();
        $list = factory(GroceryList::class)->create();

        $this->json('POST', '/grocerylist/' . $list->getKey() .'/add/' . $recipe->getKey());

        $this->assertResponseOk();
    }
}
