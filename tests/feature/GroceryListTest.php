<?php

use App\Entities\Department;
use App\Entities\Recipe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\GroceryList;
use App\Entities\Item;

class GroceryListControllerTest extends TestCase
{
    use DatabaseTransactions, testHelpers, DatabaseMigrations;

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

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function it_makes_a_store_grocery_list_request()
    {
        $this->disableExceptionHandling();

        $departments = factory(Department::class, 2)->create();

        $this->post('/grocerylist', [
            'title' => 'poo32',
            'items' => [
                ['name' => 'item1', 'quantity' => 1, 'department_id' => $departments->first()->getKey()],
                ['name' => 'item2', 'quantity' => 2, 'department_id' => $departments->last()->getKey()],
            ]
        ]);

        $this->assertResponseStatus(302);

        $this->assertCount(1, GroceryList::get());
    }

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function make_update_request()
    {
        $grocerylist = factory(GroceryList::class)->create();

        //items should be array
        $this->json('PATCH', "/grocerylist/{$grocerylist->getKey()}", [
            'items' => 'notarray',
        ]);

        $this->assertResponseStatus(422);

        //title should be string
        $this->json('PATCH', "/grocerylist/{$grocerylist->getKey()}", [
            'title' => []
        ]);

        $this->assertResponseStatus(422);
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
