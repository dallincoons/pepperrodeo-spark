<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PepperRodeo\GroceryLists\GroceryListPresenterBuilder;
use App\Item;
use App\Recipe;
use Illuminate\Database\Eloquent\Collection;

class GroceryListPresenterBuilderTest extends TestCase
{
    use DatabaseTransactions;

    protected $ListBuilder;

    public function setUp()
    {
        parent::setUp();

        $this->ListBuilder = new GroceryListPresenterBuilder();
    }

    /**
     * A basic test example.
     *
     * @group list-builder-tests
     * @test
     */
     public function combines_items_with_the_same_name_from_collection_of_times()
     {
        $list = factory(\App\GroceryList::class)->create();

        $list->recipes()->save(factory(Recipe::class)->create());

        $list->items()->save(factory(Item::class)->create(['name' => 'tomato', 'quantity' => 4]));
        $list->items()->save(factory(Item::class)->create(['name' => 'Tomato', 'quantity' => 2]));
        $list->items()->save(factory(Item::class)->create(['name' => 'pickles', 'quantity' => 1]));
        $list->items()->save(factory(Item::class)->create(['name' => 'Pickles', 'quantity' => 3]));
        $list->items()->save(factory(Item::class)->create(['name' => 'nuts', 'quantity' => 1]));

        $list->items()->saveMany($this->getSampleItemCollection());

        $list = $this->ListBuilder->build($list);

        $pickles = $list->items->filter(function($value, $key){
            return ($value->name == 'pickles');
        });

         $tomatoes = $list->items->filter(function($value, $key){
             return ($value->name == 'tomato');
         })->first();

         $nuts = $list->items->filter(function($value, $key){
             return ($value->name == 'nuts');
         })->first();

         $this->assertCount(1, $pickles);
         $this->assertEquals(4, $pickles->first()->quantity);
         $this->assertEquals(6, $tomatoes->quantity);
         $this->assertEquals(1, $nuts->quantity);
     }

     private function getSampleItemCollection()
     {
        return factory(Item::class, 5)->create();
     }

}
