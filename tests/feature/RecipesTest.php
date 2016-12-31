<?php


use App\Entities\GroceryList;
use App\Entities\Item;
use App\Entities\Recipe;
use App\Entities\RecipeCategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations, testHelpers;

    protected $Recipes;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();

    }

    /**
     * @group recipe-tests
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
     * @group recipe-tests
     * @return void
     *
     * @test
     */
    public function see_recipe_on_single_recipe_page()
    {
        $this->buildSampleRecipe();
        $recipe = $this->Recipes->first();

        $this->visit('/recipe/' . $recipe->getKey())
            ->see($recipe->title)
            ->see($recipe->items()->first()->name);
    }

    /**
     * @group recipe-tests
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
     * @group recipe-tests
     * @test
     */
    public function create_recipe_with_no_items_fails()
    {
        $recipe = factory(Recipe::class)->make();
        $category = RecipeCategory::find($recipe->recipe_category_id);

        $this->post('recipe', $recipe->toArray() + [
                'category' => (string)$category->id . ',' . $category->name,
                'recipeFields' => [
                    []
                ]
        ]);

        $this->assertResponseStatus(302);
    }

    /**
     * @group recipe-tests
     * @test
     */
    public function make_recipe_update_request()
    {
        $recipe = factory(Recipe::class)->create();

        //title should be string
        $this->json('PATCH', "/recipe/{$recipe->getKey()}", [
            'title' => [],
        ]);

        $this->assertResponseStatus(422);

        //category should be string
        $this->json('PATCH', "/recipe/{$recipe->getKey()}", [
            'category' => [],
        ]);

        $this->assertResponseStatus(422);
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

    /**
     * @group recipe-tests
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