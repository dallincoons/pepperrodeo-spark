<?php

namespace Tests\Browser\Recipes;

use App\Entities\Department;
use App\Entities\Recipe;
use App\Entities\RecipeCategory;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CreateRecipePage;
use Tests\DuskTestCase;

class CreateRecipeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function creates_a_new_recipe()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $this->be($user);
            $browser->loginAs($user);

            $category = factory(RecipeCategory::class)->create();
            $user->recipeCategories()->save($category);

            $department = factory(Department::class)->create();

            $browser->visit(new CreateRecipePage());

            $browser->type('title', 'test-title');
            $browser->select('category', (string)$category->getKey() . ',' . $category->name);
            $browser->type('recipeFields[-1][quantity]', 2);
            $browser->type('recipeFields[-1][type]', 'test-type');
            $browser->type('recipeFields[-1][name]', 'test-name');
            $browser->select('recipeFields[-1][department_id]', (string)$department->getKey());
            $browser->type('directions', 'cook stuff');

            $browser->press('Save');

            $browser->waitForText('test-title');

            $recipe = Recipe::first();

            $browser->assertPathIs('/recipe/' . $recipe->getKey());
            $browser->assertSee('test-title');
            $browser->assertSee($category->name);
            $browser->assertSee('2');
            $browser->assertSee('test-type');
            $browser->assertSee('test-name');
            $browser->assertSee('cook stuff');
        });
    }
}
