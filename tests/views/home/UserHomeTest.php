<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Recipe;
use App\Item;
use Carbon\Carbon;

class UserHome extends TestCase
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
     * @group UserHome
     *
     * @return void
     * @test
     */
    public function view_recipes_on_home_page()
    {
        $exampleRecipe = $this->exampleRecipeWithItems(5, ['created_at' => Carbon::now()->subDay()]);
        $exampleRecipe2 = $this->exampleRecipeWithItems(3, ['created_at' => Carbon::now()->subDays(2)]);
        $exampleRecipe3 = $this->exampleRecipeWithItems(6, ['created_at' => Carbon::now()->subDays(3)]);

        $this->User->recipes()->save($exampleRecipe);
        $this->User->recipes()->save($exampleRecipe2);
        $this->User->recipes()->save($exampleRecipe3);

        $this->visit('/recipe')
            ->see($exampleRecipe->title)
            ->see($exampleRecipe2->title)
            ->see($exampleRecipe3->title);
    }

    /**
     * @group UserHome
     *
     * @test
     */
    public function click_recipe_on_front_page()
    {
        $exampleRecipe = $this->exampleRecipeWithItems(5);
        $exampleRecipe2 = $this->exampleRecipeWithItems(3);

        $this->User->recipes()->save($exampleRecipe);
        $this->User->recipes()->save($exampleRecipe2);

        $this->visit('/recipe')
             ->click($exampleRecipe->title)
             ->seePageIs('/recipe/' . $exampleRecipe->id);
    }

    /**
     * @group UserHome
     *
     * @test
     */
    public function click_add_to_recipe_link()
    {
        $this->visit('/')
             ->click('Add a Recipe')
             ->seePageIs('/recipe/create');
    }

    /**
     * @group UserHome
     *
     * @test
     */
    public function click_add_grocerylist_link()
    {
        $this->visit('/')
             ->click('Create a List')
             ->seePageIs('/grocerylist/create');
    }

    protected function exampleRecipeWithItems($howMany, $attributes = [])
    {
        $recipe = factory(Recipe::class)->create($attributes);
        $recipe->items()->saveMany(factory(Item::class, $howMany)->create());

        return $recipe;
    }
}
