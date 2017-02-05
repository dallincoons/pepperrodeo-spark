<?php

namespace Tests\Browser\GroceryList;

use App\Entities\Department;
use App\Entities\GroceryList;
use App\Entities\Item;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowGroceryListTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_deletes_item_in_grocery_list()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $this->be($user);
            $browser->loginAs($user);

            $grocerylist = factory(GroceryList::class)->create();
            $item = factory(Item::class)->create();
            $grocerylist->items()->save($item);

            $browser->visit('/grocerylist/' . $grocerylist->getKey());

            $browser->waitFor('#toggleOptions' . $item->getKey(), 20);

            $browser->click('#toggleOptions' . $item->getKey());

            $browser->click('#delete' . $item->getKey());

            $browser->waitForText('Are you sure you want to remove');
            $browser->assertSee('Are you sure you want to remove');
            $browser->assertSee('Yes');

            $browser->press('Yes');

            $browser->waitUntilMissing('#toggleOptions' . $item->getKey());
            $browser->assertDontSee($item->title);
        });
    }

    /**
     * @test
     */
    public function it_edits_an_item_in_grocery_list()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $this->be($user);
            $browser->loginAs($user);

            $grocerylist = factory(GroceryList::class)->create();
            $item = factory(Item::class)->create();
            $grocerylist->items()->save($item);

            $browser->visit('/grocerylist/' . $grocerylist->getKey());

            $browser->waitFor('#toggleOptions' . $item->getKey(), 20);

            $browser->click('#toggleOptions' . $item->getKey());

            $browser->waitFor('#edit' . $item->getKey());
            $browser->click('#edit' . $item->getKey());

            $department = Department::first();

            $browser->type('quantity', 999);
            $browser->type('name', 'test-name');
            $browser->type('type', 'test-type');
            $browser->select('department', $department->getKey());

            $browser->click('#save-edit');

            $browser->waitForText('999');
            $browser->assertSee('999');
            $browser->assertSee('test-name');
            $browser->assertSee('test-type');
            $browser->assertSee($department->getKey());
        });
    }
}
