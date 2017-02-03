<?php


use App\Entities\Department;
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

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();

        $this->withoutMiddleware();
    }

    /**
     * @group recipe-tests
     * @test
     */
    public function create_recipe_with_existing_category()
    {
        $recipe = factory(Recipe::class)->make();
        $category = RecipeCategory::find($recipe->recipe_category_id);
        $department = factory(Department::class)->create();

        $response = $this->post('recipe', $recipe->toArray() + [
                'category' => (string)$category->id . ',' . $category->name,
                'title' => 'heyo',
                'directions' => 'youll know what to do',
                'recipeFields' => [
                    [
                        'type' => 'test_type',
                        'name' => 'test_name',
                        'department_id' => $department->getKey(),
                        'quantity' => 2.0
                    ]
                ]
            ]);

        $response->assertStatus(302);
    }

    /**
     * @group recipe-tests
     * @test
     */
    public function create_recipe_with_no_items_fails()
    {
        $recipe = factory(Recipe::class)->make();
        $category = RecipeCategory::find($recipe->recipe_category_id);

        $response = $this->post('recipe', $recipe->toArray() + [
                'category' => (string)$category->id . ',' . $category->name,
                'recipeFields' => [
                    []
                ]
        ]);

        $response->assertStatus(302);
    }

    /**
     * @group recipe-tests
     * @test
     */
    public function make_recipe_update_request()
    {
        $recipe = factory(Recipe::class)->create();

        //title should be string
        $response = $this->json('PATCH', "/recipe/{$recipe->getKey()}", [
            'title' => [],
        ]);

        $response->assertStatus(422);

        //category should be string
        $response = $this->json('PATCH', "/recipe/{$recipe->getKey()}", [
            'category' => [],
        ]);

        $response->assertStatus(422);
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

        $response = $this->json('POST', '/grocerylist/' . $list->getKey() .'/add', ['grocerylist' => $list->getKey(), 'recipes' => [$recipe->getKey()]]);

        $response->assertStatus(200);
    }

    /**
     * @group recipe-tests
     *
     * @test
     */
    public function it_makes_request_to_update_recipe()
    {
//        $this->disableExceptionHandling();
//
//        $recipe = factory(Recipe::class)->create();
//        $category = factory(RecipeCategory::class)->create();
//
//        $this->patch('/recipe/' . $recipe->getKey(), [
//            'title' => 'fake-title',
//            'directions' => 'fake directions',
//            'category' => $category->getKey() . ',' . $category->name
//        ]);
//
//        $this->assertResponseOk();
//
//        $this->assertEquals('fake-title', $recipe->fresh()->title);
    }

    /**
     * @group recipe-tests
     *
     * @test
     */
    public function it_makes_request_to_delete_multiple_recipes()
    {
        $this->disableExceptionHandling();

        $recipes = factory(Recipe::class, 2)->create();

        $this->delete('/recipe/deleteMultiple', ['recipeIds' => $recipes->pluck('id')->toArray()]);

        $this->assertCount(0, Recipe::get());
    }
}
