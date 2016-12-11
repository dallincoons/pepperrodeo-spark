<?php

use App\Entities\Item;
use App\Entities\ItemCategory;
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

        $this->post('recipecategory', $recipeCategory->toArray());

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

        $this->delete('recipecategory/' . $recipeCategory->getKey());

        $this->dontSeeInDatabase('recipe_categories', ['name' => $recipeCategory->name]);
    }

    /**
     * @group recipe-category-tests
     *
     * @test
     */
    public function fails_when_deleting_non_existant_recipe_category()
    {
        $this->delete('recipecategory/1');

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
        $this->patch('recipecategory/' . $recipeCategory->getKey(), ['name' => $alteredName]);

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

        $this->delete('recipecategory/' . $recipeCategory->getKey());

        $this->assertNotNull($recipeCategory->fresh());
        $this->assertTrue($recipe->fresh()->exists());
        $this->assertResponseStatus(290);

        $this->delete('recipecategory/' . $recipeCategory->getKey(), ['force' => 'true']);

        $this->assertNull($recipeCategory->fresh());
        $this->assertNull($recipe->fresh());
        $this->assertResponseStatus(200);
    }
}
