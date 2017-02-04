<?php

namespace Tests\Browser\Pages;

use App\Entities\Recipe;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class SingleRecipePage extends BasePage
{
    protected $recipe;

    public function __construct()
    {
        if(!$this->recipe) {
            $this->recipe = factory(Recipe::class)->create();
        }
    }

    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/recipe/' . $this->recipe->getKey();
    }

    /**
     * Assert that the browser is on the page.
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
