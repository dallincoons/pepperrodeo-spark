<?php

use App\Entities\GroceryList;
use App\Entities\Item;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroceryListItemTest extends TestCase
{
    use DatabaseMigrations, testHelpers;

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
    public function deletes_item_from_grocery_list()
    {
        $this->disableExceptionHandling();

        $grocerylist = factory(GroceryList::class)->create();

        $item = factory(Item::class)->create();
        $item2 = factory(Item::class)->create();

        $grocerylist->items()->saveMany([$item, $item2]);

        $this->assertCount(2, $grocerylist->items);

        $this->post('grocerylistitem/remove', ['grocerylist' => $grocerylist->getKey(), 'itemIds' => $item->getKey()]);

        $this->assertResponseOk();
        $this->assertCount(1, $grocerylist->fresh()->items);
    }
}
