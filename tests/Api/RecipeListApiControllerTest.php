<?php

use App\Entities\GroceryList;
use App\Entities\Recipe;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipeListApiControllerTest extends TestCase
{
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
        $list2 = factory(GroceryList::class)->create();

        $this->json('POST', '/grocerylist/' . $list->getKey() .'/add/' . $recipe->getKey());

        $this->assertResponseOk();

        $this->seeJson([
            'grocerylists' =>
                collect([$list2])->pluck('id', 'title')
        ]);
    }
}
