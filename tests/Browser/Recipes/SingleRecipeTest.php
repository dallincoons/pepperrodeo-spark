<?php

namespace Tests\Feature\Browser\Recipes;

use App\Entities\GroceryList;
use App\Entities\Item;
use App\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\SingleRecipePage;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SingleRecipeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_clicks_edit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(factory(User::class)->create());
            $singleRecipePage = new SingleRecipePage();
            $browser->visit($singleRecipePage);

            $browser->clickLink('Edit');

            $recipe = $singleRecipePage->getRecipe();

            $browser->assertPathIs('/recipe/' . $recipe->getKey() . '/edit');
        });
    }

    /**
     * @test
     */
    public function it_clicks_delete()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(factory(User::class)->create());
            $singleRecipePage = new SingleRecipePage();
            $browser->visit($singleRecipePage);

            $browser->clickLink('Delete');

            $recipe = $singleRecipePage->getRecipe();

            $browser->waitUsing(6, 2, function() use($browser){
                return $browser->assertPathIs('/recipe');
            });

            $browser->assertPathIs('/recipe');
            $browser->assertDontSee($recipe->title);
        });
    }

    /**
     * @test
     */
    public function it_adds_recipe_to_grocery_list()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $grocerylist = factory(GroceryList::class)->create();
            $user->groceryLists()->save($grocerylist);

            $browser->loginAs($user);
            $this->be($user);
            $singleRecipePage = new SingleRecipePage();

            $recipe = $singleRecipePage->getRecipe();
            $item = factory(Item::class)->create();
            $recipe->items()->save($item);

            $browser->visit($singleRecipePage);

            $browser->pause(2000);

            $browser->clickLink('Add to Grocery List');

            $browser->waitFor('#list' . $grocerylist->getKey());
            $browser->click('#list' . $grocerylist->getKey());

            $browser->waitForText('You have successfully added');
            $browser->assertSee('You have successfully added');

            $browser->assertDontSeeIn('#availableLists', $grocerylist->title);

            $browser->clickLink($grocerylist->title);
            $browser->assertPathIs('/grocerylist/' . $grocerylist->getKey());

            $this->assertContains($item->name, $grocerylist->fresh()->items->pluck('name'));
        });
    }
}
