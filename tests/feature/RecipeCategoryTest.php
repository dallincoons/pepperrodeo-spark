<?php

use App\Entities\Recipe;
use App\Entities\RecipeCategory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipeCategoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function add_a_new_recipe_category()
    {
        $recipeCategory = factory(RecipeCategory::class)->make();

        $this->post('recipe/categories', $recipeCategory->toArray());

        $this->assertDatabaseHas('recipe_categories', ['name' => $recipeCategory->name]);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function can_delete_a_new_recipe_category()
    {
        $recipeCategory = factory(RecipeCategory::class)->create();

        $this->delete('recipe/categories/' . $recipeCategory->getKey());

        $this->assertDatabaseMissing('recipe_categories', ['name' => $recipeCategory->name]);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function fails_when_deleting_non_existant_recipe_category()
    {
        $response = $this->delete('recipe/categories/1');

        $response->assertStatus(404);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function can_edit_recipe_category()
    {
        $recipeCategory = factory(RecipeCategory::class)->create();

        $alteredName = $recipeCategory->name . 'altered';
        $this->patch('recipe/categories/' . $recipeCategory->getKey(), ['name' => $alteredName]);

        $this->assertEquals($alteredName, $recipeCategory->fresh()->name);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function delete_recipe_category_with_associated_recipes()
    {
        $recipeCategory = factory(RecipeCategory::class)->create();

        $recipe = factory(Recipe::class)->create([
            'recipe_category_id' => $recipeCategory->getKey()
        ]);

        $response = $this->delete('recipe/categories/' . $recipeCategory->getKey());

        $this->assertNull($recipeCategory->fresh());
        $this->assertNull($recipe->fresh());
        $response->assertStatus(200);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function it_makes_a_request_to_see_recipes_of_a_certain_category()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->get('/recipe/categories/' . $recipe->category->getKey());

        $response->assertStatus(200);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function it_deletes_all_recipes_associated_with_a_deleted_category()
    {
        $count = 2;
        $recipes = factory(Recipe::class, $count)->create();
        $category = factory(RecipeCategory::class)->create();

        $category->recipes()->saveMany($recipes);

        $this->assertCount($count, $category->recipes);

        $this->delete('recipe/categories/' . $category->getKey());

        $this->assertNull($category->fresh());
        $this->assertCount(0, Recipe::get());
    }
}
