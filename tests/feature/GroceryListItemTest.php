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
    public function it_stores_a_new_grocery_list_item()
    {
        $this->disableExceptionHandling();

        $grocerylist = factory(GroceryList::class)->create();

        $listitem = factory(Item::class)->make();

        $this->assertCount(0, $grocerylist->items);

        $data = [
            'name' => $listitem->name,
            'type' => $listitem->type,
            'quantity' => $listitem->quantity,
            'department_id' => $listitem->department_id
        ];

        $this->post("grocerylist/{$grocerylist->getKey()}/item/create", $data);

        $this->assertResponseOk();
        $this->assertCount(1, $grocerylist->fresh()->items);
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

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function update_a_grocery_list_item()
    {
        $this->disableExceptionHandling();

        $item = factory(Item::class)->create(['quantity' => 1]);

        $this->assertEquals(1, $item->quantity);

        $item->quantity = 2;

        $itemArray = $item->toArray();

        $this->patch('/grocerylistitem/edit/' . $item->getKey(), ['item' => ['quantity' => array_get($itemArray, 'quantity')]]);

        $this->assertResponseOk();
        $this->assertEquals(2, $item->quantity);
    }
}
