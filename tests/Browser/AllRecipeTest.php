<?php

namespace Tests\Browser;

use App\Entities\Recipe;
use App\User;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\RecipePage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AllRecipeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_clicks_to_edit_a_recipe()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $recipes = factory(Recipe::class, 2)->create();
            $user->recipes()->saveMany($recipes);

            $browser->loginAs($user);

            $browser->visit(new RecipePage());

            $browser->click('#toggleOptions' . $recipes->first()->getKey());
            $browser->click('#edit' . $recipes->first()->getKey());

            $browser->assertPathIs('/recipe/' . $recipes->first()->getKey() . '/edit');
        });
    }

    /**
     * @test
     */
    public function it_clicks_to_delete_a_recipe()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $recipes = factory(Recipe::class, 2)->create();
            $user->recipes()->saveMany($recipes);

            $browser->loginAs($user);

            $recipePage = new RecipePage();
            $browser->visit($recipePage);

            $browser->click('#toggleOptions' . $recipes->first()->getKey());
            $browser->click('#delete' . $recipes->first()->getKey());

            $browser->assertPathIs($recipePage->url());
            $browser->waitUntilMissing('#toggleOptions' . $recipes->first()->getKey());
            $browser->assertDontSee($recipes->first()->title);
            $browser->assertSee($recipes->last()->title);
        });
    }
}
