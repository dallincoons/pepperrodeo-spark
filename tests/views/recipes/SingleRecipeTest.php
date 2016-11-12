<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Recipe;
use App\User;
use App\Item;

class SingleRecipeTest extends TestCase
{
    use DatabaseTransactions;
    use testHelpers;

    protected $User;

    public function setUp()
    {
        parent::setUp();

        $this->User = factory(User::class)->create();

        $this->be($this->User);
    }

    /**
     * A basic test example.
     *
     * @group single-recipe-view
     * @return void
     */
    public function testExample()
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
