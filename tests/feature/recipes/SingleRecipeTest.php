<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Recipe;
use App\User;
use App\Entities\Item;

class SingleRecipeTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;
    use testHelpers;

    protected $User;

    public function setUp()
    {
        parent::setUp();

        $this->User = factory(User::class)->create();

        $this->be($this->User);
    }

    /**
     * @group single-recipe-view
     * @return void
     */
    public function see_recipe_on_all_recipes_page()
    {
        $recipe = $this->exampleRecipeWithItems();

        $this->visit('/recipe/' . $recipe->getKey())
             ->see($recipe->title)
             ->see($recipe->items()->first()->name);
    }

    protected function exampleRecipeWithItems($howMany = 5, $attributes = [])
    {
        $recipe = factory(Recipe::class)->create($attributes);
        $recipe->items()->saveMany(factory(Item::class, $howMany)->create());

        return $recipe;
    }
}
