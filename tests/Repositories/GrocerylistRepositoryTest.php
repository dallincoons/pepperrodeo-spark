<?php

use App\GroceryList;
use App\Item;
use App\Repositories\GroceryListRepository;

class GrocerylistRepositoryTest extends TestCase
{
    /**
     * @group repository-tests
     * @group grocerylist-repository-tests
     *
     * @test
     */
    public function updates_grocery_list_including_new_items()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $item = factory(Item::class)->create();
        $grocerylist->items()->save($item);

        GroceryListRepository::update([
            'items' => [
                [
                    'id' => -1,
                    'name' => 'shapoopy',
                    'quantity' => 2,
                    'item_category_id' => 1
                ]
            ],
            'title' => $grocerylist->title
        ], $grocerylist);

        $this->assertFalse($grocerylist->items->pluck('name')->contains($item->name));
        $this->assertTrue($grocerylist->items->pluck('name')->contains('shapoopy'));
    }
}
