<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\GroceryList;
use App\Item;

class GroceryListControllerTest extends TestCase
{
    use DatabaseTransactions;
    use testHelpers;

    protected $GroceryList;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function show_all_grocery_lists_that_belong_to_user()
    {
        $this->buildSampleGroceryList();

        $firstlist = $this->GroceryList->first();
        $lastlist = $this->GroceryList->last();

        $this->visit('grocerylist')
            ->see($firstlist->title)
            ->see($lastlist->title);
    }

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function click_grocerylist_link_and_visit_individual_list_page()
    {
        $this->buildSampleGroceryList();

        $firstlist = $this->GroceryList->first();

        $this->visit('grocerylist')
            ->click($firstlist->title)
            ->see($firstlist->title);
    }

    private function buildSampleGroceryList()
    {
        $this->user->recipes()->save(factory(GroceryList::class)->make());
        $this->GroceryList = factory(GroceryList::class, 3)
            ->create(['user_id' => $this->user->id])
            ->each(function($recipe){
                $recipe->items()->saveMany(factory(Item::class, 5)->make());
            });

    }
}
