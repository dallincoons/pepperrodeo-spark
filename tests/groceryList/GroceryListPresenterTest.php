<?php

use  App\PepperRodeo\GroceryLists\GroceryListPresenter;
use App\Item;
use App\Recipe;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroceryListPresenterTest extends TestCase
{
    protected $presenter;

    public function setUp()
    {
        parent::setUp();

        $this->presenter = new GroceryListPresenter();
    }

    /**
     * @group grocery-list-presenter-tests
     * @return void
     * @test
     */
    public function adds_items_to_presenter()
    {
        $items = factory(Item::class, 5)->create();

        foreach($items as $item){

            $this->presenter->addItem($item);

        }

        $this->assertEquals($this->presenter->items, collect($items));

    }
}
