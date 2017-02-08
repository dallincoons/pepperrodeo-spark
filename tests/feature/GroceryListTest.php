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

        $response = $this->get('/grocerylist');

        $response->assertSee($firstlist->title);
        $response->assertSee($lastlist->title);
        $response->assertStatus(200);
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

        $response = $this->get('/grocerylist');
        $response->assertSee($firstlist->title);
        $response->assertSee($firstlist->title);
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

        $response = $this->post('/grocerylist', [
            'title' => 'poo32',
            'items' => [
                ['name' => 'item1', 'type' => 'test-type', 'quantity' => 1, 'department_id' => $departments->first()->getKey()],
                ['name' => 'item2', 'type' => 'test-type', 'quantity' => 2, 'department_id' => $departments->last()->getKey()],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, GroceryList::get());
    }

    /**
     * @test
     */
    public function it_cant_create_item_with_zero_quantity()
    {
        $department = factory(Department::class)->create();

        $response = $this->post('/grocerylist', [
            'title' => 'poo32',
            'items' => [
                ['name' => 'item1', 'type' => 'test-type', 'quantity' => 0, 'department_id' => $department->getKey()],
            ]
        ]);

        $response->assertStatus(302);
        $this->assertNull(GroceryList::where(['title' => 'poo32'])->first());

        $response = $this->post('/grocerylist', [
            'title' => 'poo32',
            'items' => [
                ['name' => 'item1', 'type' => 'test-type', 'quantity' => .01, 'department_id' => $department->getKey()],
            ]
        ]);

        $response->assertStatus(200);
        $this->assertNotNull(GroceryList::where(['title' => 'poo32'])->first());
    }

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function it_makes_show_list_request()
    {
        $grocerylist = factory(GroceryList::class)->create();

        $response = $this->get('/grocerylist/' . $grocerylist->getKey());

        $response->assertStatus(200);
    }

    /**
     * @group grocery-list-tests
     *
     * @test
     */
    public function make_update_grocery_list_request()
    {
        $departments = factory(Department::class)->create();

        $grocerylist = factory(GroceryList::class)->create();
        $item = factory(Item::class, 3)->make();
        $grocerylist->items()->saveMany($item);

        //items should be array
        $response = $this->json('PATCH', "/grocerylist/{$grocerylist->getKey()}", [
            'items' => 'notarray',
        ]);

        $response->assertStatus(422);

        //title should be string
        $response = $this->json('PATCH', "/grocerylist/{$grocerylist->getKey()}", [
            'title' => []
        ]);

        $response->assertStatus(422);

        $response = $this->json('PATCH', "/grocerylist/{$grocerylist->getKey()}", [
            'title' => 'fake-title',
            'items' => [
                ['id' => -1, 'name' => 'item1', 'type' => 'test', 'quantity' => 0, 'department_id' => $departments->first()->getKey()],
            ]
        ]);

        $response->assertStatus(422);

        //title should be string
        $response = $this->json('PATCH', "/grocerylist/{$grocerylist->getKey()}", [
            'title' => 'fake-title',
            'items' => [
                ['id' => -1, 'name' => 'item1', 'type' => 'test', 'quantity' => 1, 'department_id' => $departments->first()->getKey()],
            ]
        ]);

        $this->assertEquals('fake-title', $grocerylist->fresh()->title);
        $this->assertCount(1, $grocerylist->fresh()->items);
        $response->assertStatus(200);
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
