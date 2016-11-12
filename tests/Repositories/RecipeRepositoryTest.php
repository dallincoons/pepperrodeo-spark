<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\RecipeRepository;
use App\User;
use App\Recipe;
use App\RecipeCategory;
use App\Item;

class RecipeRepositoryTest extends TestCase
{
    use DatabaseTransactions;

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

        $newTitle = str_random();
        $newCategory = 1337;
        $newDirections = str_random();
        RecipeRepository::updateRecipe($recipe, [
            'title' => $newTitle,
            'recipe_category_id' => $newCategory,
            'directions' => $newDirections
        ]);

        $this->assertEquals($newTitle, $recipe->title);
        $this->assertEquals($newCategory, $recipe->recipe_category_id);
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
                'item_category_id' => $recipeItems->first()->item_category_id,
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
        $recipe = factory(Recipe::class)->create();

        RecipeRepository::updateRecipeItems($recipe, [
            [
                'id' => '',
                'quantity' => 1,
                'type' => str_random(),
                'item_category_id' => 2,
                'name' => str_random()
            ],
            [
                'id' => '',
                'quantity' => 1,
                'type' => str_random(),
                'item_category_id' => 2,
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
                'item_category_id' => $recipeItems->first()->item_category_id,
                'name' => str_random()
            ],
            [
                'id' => $recipeItems->last()->getKey(),
                'quantity' => $recipeItems->first()->quantity,
                'type' => $recipeItems->first()->type,
                'item_category_id' => $recipeItems->first()->item_category_id,
                'name' => str_random()
            ]
        ]);

        $this->assertEquals(2, $recipe->fresh()->items->count());
    }
}
