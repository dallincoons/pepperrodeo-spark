<?php

namespace Tests\Feature\Browser;

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
            $browser->login();
            $singleRecipePage = new SingleRecipePage();
            $browser->visit($singleRecipePage);

            $browser->clickLink('Edit');

            $recipe = $singleRecipePage->getRecipe();

            $browser->assertPathIs('/recipe/' . $recipe->getKey() . '/edit');
        });
    }
}
