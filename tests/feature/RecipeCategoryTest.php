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

        $this->seeInDatabase('recipe_categories', ['name' => $recipeCategory->name]);
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

        $this->dontSeeInDatabase('recipe_categories', ['name' => $recipeCategory->name]);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function fails_when_deleting_non_existant_recipe_category()
    {
        $this->delete('recipe/categories/1');

        $this->assertResponseStatus(404);
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

        $this->delete('recipe/categories/' . $recipeCategory->getKey());

        $this->assertNotNull($recipeCategory->fresh());
        $this->assertTrue($recipe->fresh()->exists());
        $this->assertResponseStatus(290);

        $this->delete('recipe/categories/' . $recipeCategory->getKey(), ['force' => 'true']);

        $this->assertNull($recipeCategory->fresh());
        $this->assertNull($recipe->fresh());
        $this->assertResponseStatus(200);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function it_makes_a_request_to_see_recipes_of_a_certain_category()
    {
        $recipe = factory(Recipe::class)->create();

        $this->get('/recipe/categories/' . $recipe->category->getKey());

        $this->assertResponseOk();
    }
}
