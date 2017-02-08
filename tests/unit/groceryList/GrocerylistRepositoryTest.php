<?php

use App\Entities\GroceryList;
use App\Entities\Item;
use App\Entities\Recipe;
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
    public function stores_new_list()
    {
        $items = factory(Item::class, 2)->create();

        $newItem = [
            'id' => -1,
            'name' => 'foobar_name',
            'type' => 'bottle',
            'quantity' => 1,
            'department_id' => 1
        ];

        $newItem2 = [
            'id' => -2,
            'name' => 'foobar_name2',
            'type' => 'can',
            'quantity' => 2,
            'department_id' => 2
        ];

        $items->add($newItem);
        $items->add($newItem2);

        $grocerylist = GroceryListRepository::store([
            'title' => 'foobar_title',
            'items' => $items,
        ]);

        foreach($items->pluck('name') as $itemName)
        {
            $this->assertContains($itemName, $grocerylist->items->pluck('name'));
        }

        foreach($items->pluck('type') as $itemName)
        {
            $this->assertContains($itemName, $grocerylist->items->pluck('type'));
        }
    }

    /**
     * @group repository-tests
     * @group grocerylist-repository-tests
     *
     * @test
     */
    public function add_a_recipe_to_grocery_list()
    {
        $grocerylist = factory(GroceryList::class)->create();
        $grocerylist2 = factory(GroceryList::class)->create();
        $recipe = factory(Recipe::class)->create();
        $items = factory(Item::class, 2)->create();
        $recipe->items()->saveMany($items);
        \Auth::user()->groceryLists()->save($grocerylist);
        \Auth::user()->groceryLists()->save($grocerylist2);

        GroceryListRepository::addRecipe($grocerylist2->getKey(), $recipe->getKey());

        $this->assertEquals($items->count(), $grocerylist2->fresh()->items->count());
    }
}
