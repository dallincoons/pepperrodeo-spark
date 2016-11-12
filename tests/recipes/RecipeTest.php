<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Recipe;
use App\User;
use App\Item;
use App\RecipeCategory;

class RecipeTest extends TestCase
{
    use DatabaseTransactions;

    private $MainUser;
    private $MainRecipe;

    public function setUp()
    {
        parent::setUp();

        $this->MainUser = factory(User::class)->create();
        $this->MainRecipe = factory(Recipe::class)->create(['user_id' => $this->MainUser->id]);
    }

    /**
     * A basic test example.
     *
     * @group RecipeTest
     * @test
     */
    public function copy_recipe_to_another_user()
    {
        $newUser = factory(User::class)->create();

        $this->MainRecipe->copyTo($newUser);

        $this->assertCount(1, Recipe::where('user_id', '=', $this->MainUser->id)->get());
        $this->assertCount(1, Recipe::where('user_id', '=', $newUser->id)->get());
    }

    /**
     * @group RecipeTest
     * @test
     */
    public function add_item_to_recipe_from_array()
    {
        $item = factory(Item::class)->create();
        $this->MainRecipe->items()->save($item);

        $itemCount = $this->MainRecipe->items()->get()->count();

        $this->MainRecipe->addItem([
            'quantity' => 2,
            'name' => 'Ketchup',
            'item_category_id' => \App\ItemCategory::first()->getKey()
        ]);

        $this->assertEquals(count($this->MainRecipe->items()->get()), ($itemCount + 1));
    }
}
