<?php

namespace Tests\Browser;

use App\Entities\Recipe;
use App\User;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\RecipePage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_adds_an_item_()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $recipes = factory(Recipe::class, 2)->create();
            $user->recipes()->saveMany($recipes);

            $browser->loginAs($user);

            $browser->visit(new RecipePage());

            $browser->click('.fa-ellipsis-h:first-of-type');
            $browser->clickLink('Edit');

            $browser->assertPathIs('/recipe/' . $recipes->first()->getKey() . '/edit');
        });
    }
}
