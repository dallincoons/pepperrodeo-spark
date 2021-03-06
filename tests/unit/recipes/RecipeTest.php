<?php

use App\Entities\Department;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Entities\Recipe;
use App\User;
use App\Entities\Item;

class RecipeTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

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
            'department_id' => Department::first()->getKey()
        ]);

        $this->assertEquals(count($this->MainRecipe->items()->get()), ($itemCount + 1));
    }
}
