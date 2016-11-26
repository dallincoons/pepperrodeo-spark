<?php

use App\Entities\GroceryList;
use App\Entities\Item;
use App\Repositories\GroceryListRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GrocerylistRepositoryTest extends TestCase
{
    use DatabaseMigrations;

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
                ],
                [
                    'id' => -2,
                    'name' => 'shapoopy_dos',
                    'quantity' => 2,
                    'item_category_id' => 1
                ]
            ],
            'title' => $grocerylist->title
        ], $grocerylist);

        $this->assertFalse($grocerylist->items->pluck('name')->contains($item->name));
        $this->assertTrue($grocerylist->items->pluck('name')->contains('shapoopy'));
        $this->assertTrue($grocerylist->items->pluck('name')->contains('shapoopy_dos'));
    }
}
