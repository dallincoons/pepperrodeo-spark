<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Recipe;
use App\Entities\GroceryList;
use App\Entities\Item;

class RecipeControllerTest extends TestCase
{
    use DatabaseTransactions;
    use testHelpers;

    protected $Recipes;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();

    }

    /**
     * @group recipe-controller
     * @test
     */
    public function views_recipe_dashboard_and_views_links_for_recipes()
    {
        $this->buildSampleRecipe();

        $firstRecipe = $this->Recipes->first();
        $lastRecipe = $this->Recipes->last();

        $this->visit('recipe')
             ->see($firstRecipe->title)
             ->see($lastRecipe->title);
    }

    /**
     * @group recipe-controller
     * @test
     */
    public function click_recipe_link_and_visit_individual_recipe_page()
    {
        $this->buildSampleRecipe();
        $grocerylists = factory(GroceryList::class, 2)->create(['user_id' => $this->user->id]);

        $firstRecipe = $this->Recipes->first();

        $grocerylists->first()->recipes()->save($firstRecipe);

        $this->visit('recipe')
            ->click($firstRecipe->title)
            ->see($firstRecipe->title);
    }

    /**
     * @group recipe-controller
     * @test
     */
    public function click_link_to_add_recipe_to_grocery_list()
    {
        $firstRecipe = Recipe::first();

//        $this->visit('recipe/' . $firstRecipe->getKey())
//            ->see('Add to Grocery List')
//            ->click('Add to Grocery List')
//            ->see('Grocery Lists');
    }

    private function buildSampleRecipe()
    {
        $grocerylists = factory(GroceryList::class)->create()->get();

        $this->user->recipes()->save(factory(Recipe::class)->make());
        $this->Recipes = factory(Recipe::class, 3)
            ->create(['user_id' => $this->user->id])
            ->each(function($recipe){
                $recipe->items()->saveMany(factory(Item::class, 5)->make());
            });

        $grocerylists->first()->recipes()->saveMany($this->Recipes);

    }
}
