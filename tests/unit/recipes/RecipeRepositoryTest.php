<?php

use App\Entities\Department;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Repositories\RecipeRepository;
use App\User;
use App\Entities\Recipe;
use App\Entities\RecipeCategory;
use App\Entities\Item;

class RecipeRepositoryTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    protected $repository;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->be($this->user);

    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     */
    public function testRecipesWithCategories()
    {
        $category1 = factory(RecipeCategory::class)->create(['name' => 'mobi', 'user_id' => $this->user->getKey()]);
        $category2 = factory(RecipeCategory::class)->create(['name' => 'dick', 'user_id' => $this->user->getKey()]);

        $recipe = factory(Recipe::class)->create(['recipe_category_id' => $category1->getKey(), 'user_id' => $this->user->getKey()]);
        $recipe2 = factory(Recipe::class)->create(['recipe_category_id' => $category2->getKey(), 'user_id' => $this->user->getKey()]);
        $recipe3 = factory(Recipe::class)->create(['recipe_category_id' => $category2->getKey(), 'user_id' => $this->user->getKey()]);

        $actual = RecipeRepository::recipesWithCategories();

       $this->assertArrayHasKey($category1->name, $actual);
       $this->assertArrayHasKey($category2->name, $actual);
       $this->assertEquals($recipe->title, $actual[$category1->name][0]->title);
       $this->assertEquals($recipe2->title, $actual[$category2->name][0]->title);
       $this->assertEquals($recipe3->title, $actual[$category2->name][1]->title);
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function update_recipe()
    {
        $recipe = factory(Recipe::class)->create();
        $recipeCategory = factory(RecipeCategory::class)->create();

        $newTitle = str_random();
        $newDirections = str_random();
        RecipeRepository::updateRecipe($recipe, [
            'title' => $newTitle,
            'category' => ['id' => $recipeCategory->getKey(), 'name' => $recipeCategory->name],
            'directions' => $newDirections
        ]);

        $this->assertEquals($newTitle, $recipe->title);
        $this->assertEquals($recipeCategory->getKey(), $recipe->fresh()->category->getKey());
        $this->assertEquals($newDirections, $recipe->directions);
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function update_recipe_items()
    {
        $recipe = factory(Recipe::class)->create();
        $recipeItems = factory(Item::class, 5)->create();
        $recipe->items()->saveMany($recipeItems);

        $newName = str_random();

        RecipeRepository::updateRecipeItems($recipe, [
            [
                'id' => $recipeItems->first()->getKey(),
                'quantity' => $recipeItems->first()->quantity,
                'type' => $recipeItems->first()->type,
                'department_id' => $recipeItems->first()->department_id,
                'name' => $newName
            ]
        ]);

        $this->assertEquals($newName, Item::find($recipeItems->first()->getKey())->name);
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function update_and_add_recipe_items()
    {
        $department = factory(Department::class)->create();
        $recipe = factory(Recipe::class)->create();

        RecipeRepository::updateRecipeItems($recipe, [
            [
                'id' => '',
                'quantity' => 1,
                'type' => str_random(),
                'department_id' => $department->getKey(),
                'name' => str_random()
            ],
            [
                'id' => '',
                'quantity' => 1,
                'type' => str_random(),
                'department_id' => $department->getKey(),
                'name' => str_random()
            ],
        ]);

        $this->assertEquals(2, $recipe->fresh()->items->count());
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function update_and_delete_recipe_items()
    {
        $recipe = factory(Recipe::class)->create();
        $recipeItems = factory(Item::class, 5)->create();
        $recipe->items()->saveMany($recipeItems);

        RecipeRepository::updateRecipeItems($recipe, [
            [
                'id' => $recipeItems->first()->getKey(),
                'quantity' => $recipeItems->first()->quantity,
                'type' => $recipeItems->first()->type,
                'department_id' => $recipeItems->first()->department_id,
                'name' => str_random()
            ],
            [
                'id' => $recipeItems->last()->getKey(),
                'quantity' => $recipeItems->first()->quantity,
                'type' => $recipeItems->first()->type,
                'department_id' => $recipeItems->first()->department_id,
                'name' => str_random()
            ]
        ]);

        $this->assertEquals(2, $recipe->fresh()->items->count());
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function creates_recipe_using_new_category()
    {
        $department = factory(Department::class)->create();

        $recipe = RecipeRepository::store([
            'title' => 'poop',
            'directions' => 'preheat',
            'category' => ['id' => -1, 'name' => 'foocategory'],
            'category_name' => 'test',
            'recipeFields' => [[
                'name' => 'pee',
                'department_id' => $department->getKey()
            ]]
        ]);

        $this->assertEquals('foocategory', $recipe->category->name);
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function create_recipe_and_enforce_at_least_one_item()
    {
        $recipeData = [
            'title' => 'poop',
            'directions' => 'preheat',
            'category' => ['id' => -1, 'name' => 'foocategory'],
            'category_name' => 'test',
            'recipeFields' => []
        ];

        try {
            RecipeRepository::store($recipeData);
        } catch (Exception $e) {
            $this->assertContains('Recipe must contain at least one item', $e->getMessage());
            return;
        }

        $this->fail('Recipe was allowed to be created with no items');
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function creates_recipe_using_new_department()
    {
        $categoryName = 'poop';

        $recipe = RecipeRepository::store([
            'title' => 'poop',
            'directions' => 'preheat',
            'category' => ['id' => -1, 'name' => 'foocategory'],
            'category_name' => 'test',
            'recipeFields' => [[
                                   'name' => 'pee',
                                   'department_id' => -1,
                                   'department_name' => $categoryName
                               ]]
        ]);

        $this->assertEquals($categoryName, $recipe->items->where('name', 'pee')->first()->department->name);
    }

    /**
     * @group repository-tests
     * @group recipe-repository-tests
     * @test
     */
    public function creates_recipe_using_new_department_that_already_exists()
    {
        $categoryName = 'poop';

        Department::create([
            'user_id' => \Auth::user()->getKey(),
            'name' => $categoryName
        ]);

        $recipe = RecipeRepository::store([
            'title' => 'poop',
            'directions' => 'preheat',
            'category' => ['id' => -1, 'name' => 'foocategory'],
            'category_name' => 'test',
            'recipeFields' => [[
                                   'name' => 'pee',
                                   'department_id' => -1,
                                   'department_name' => $categoryName
                               ]]
        ]);

        $this->assertEquals($categoryName, $recipe->items->where('name', 'pee')->first()->department->name);
        $this->assertCount(1, Department::where('name',$categoryName)->get());
    }
}
