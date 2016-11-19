<?php

use App\Entities\Item;
use App\Entities\GroceryList;
use App\Entities\ItemCategory;
use App\Entities\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroceryListPresenterTest2 extends TestCase
{
    use DatabaseTransactions;

    protected $grocerylist;

    public function setUp()
    {
        parent::setUp();

        $this->grocerylist = factory(GroceryList::class)->create();
    }

    /**
     * @group grocery-list-presenter-tests2
     *
     * @test
     */
    public function combines_like_items_from_multiple_recipes()
    {
        $this->add_recipes_with_like_items();

        $presentableList = $this->grocerylist->present()->items;

        $this->assertEquals(1, count($presentableList->items()->unSorted()));
        $this->assertEquals(4, $presentableList->items()->unSorted()->first()->quantity);
    }

    protected function add_recipes_with_like_items()
    {
        $recipe1 = factory(Recipe::class)->create();
        $recipe2 = factory(Recipe::class)->create();
        $likeItems = factory(Item::class, 2)->create([
            'name' => 'ketchup',
            'type' => 'bottles',
            'quantity' => '2'
        ]);

        $recipe1->items()->save($likeItems->first());
        $recipe2->items()->save($likeItems->last());

        $this->grocerylist->addRecipe($recipe1);
        $this->grocerylist->addRecipe($recipe2);
    }

    /**
 * @group grocery-list-presenter-tests2
 *
 * @test
 */
    public function combines_and_groups_like_items_by_category()
    {
        list($item1, $item2) = $this->addItemsToGroceryList();

        $items = $this->grocerylist->present()->items()->byCategory();

        $this->assertEquals([$item1->category, $item2->category], array_keys($items->toArray()));
    }

    /**
     * @group grocery-list-presenter-tests2
     *
     * @test
     */
    public function combines_and_groups_like_items_by_recipe()
    {
        $this->addItemsToGroceryList();
        $recipe1 = $this->grocerylist->recipes->first();
        $recipe2 = $this->grocerylist->recipes->find(2);

        $items = $this->grocerylist->present()->items()->byRecipe();

        $this->assertEquals([$recipe1->title, $recipe2->title], array_keys($items->toArray()));
    }

    protected function addItemsToGroceryList()
    {
        $recipe1 = factory(Recipe::class)->create();
        $recipe2 = factory(Recipe::class)->create();
        $category = factory(ItemCategory::class)->create();
        $category2 = factory(ItemCategory::class)->create();
        $item1 = factory(Item::class)->create([
            'item_category_id' => $category->getKey()
        ]);
        $item2 = factory(Item::class)->create([
            'item_category_id' => $category2->getKey()
        ]);

        $recipe1->items()->save($item1);
        $recipe2->items()->save($item2);

        $this->grocerylist->addRecipe($recipe1);
        $this->grocerylist->addRecipe($recipe2);

        return [$item1, $item2];
    }

    /**
     * @group grocery-list-presenter-tests2
     *
     * @test
     */
    public function expects_exception_when_using_sorting_methods_before_items_method()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('items property is not. Call items method before any sorting methods');

        $this->grocerylist->present()->byCategory();
    }
}
