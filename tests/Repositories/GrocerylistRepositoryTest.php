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
        $recipes = factory(Recipe::class, 2)->create();
        $items = factory(Item::class, 2)->create();

        $newItem = [
            'id' => -1,
            'name' => 'foobar_name',
            'type' => 'bottle',
            'quantity' => 1,
            'item_category_id' => 1
        ];

        $newItem2 = [
            'id' => -2,
            'name' => 'foobar_name2',
            'type' => 'can',
            'quantity' => 2,
            'item_category_id' => 2
        ];

        $items->add($newItem);
        $items->add($newItem2);

        $grocerylist = GroceryListRepository::store([
            'title' => 'foobar_title',
            'items' => $items,
            'recipeIds' => $recipes->pluck('id')->implode(',')
        ]);

        foreach($items->pluck('name') as $itemName)
        {
            $this->assertContains($itemName, $grocerylist->items->pluck('name'));
        }

        foreach($items->pluck('type') as $itemName)
        {
            $this->assertContains($itemName, $grocerylist->items->pluck('type'));
        }

        foreach($recipes as $recipe)
        {
            $this->assertContains($recipe->title, $grocerylist->recipes->pluck('title'));
        }
    }

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

        $listsWithoutRecipes = GroceryListRepository::addRecipe($grocerylist2->getKey(), $recipe->getKey());

        $this->assertEquals($items->count(), $grocerylist2->fresh()->items->count());
        $this->assertEquals([$grocerylist->getKey()], $listsWithoutRecipes->pluck('id')->all());
    }
}
