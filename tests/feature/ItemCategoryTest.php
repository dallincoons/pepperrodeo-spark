<?php

use App\Entities\Department;
use App\Entities\Item;
use App\Entities\ItemCategory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemCategoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @group item-category-tests
     *
     * @test
     */
    public function categories_can_be_seen()
    {
        $category1 = factory(Department::class)->create();
        $category2 = factory(Department::class)->create();

        $this->visit('/departments');

        $this->see($category1->name);
        $this->see($category2->name);
    }

    /**
     * @group item-category-tests
     *
     * @test
     */
    public function add_a_new_item_category()
    {
        $department = factory(Department::class)->make();

        $this->post('departments', $department->toArray());

        $this->seeInDatabase('departments', ['name' => $department->name]);
    }

    /**
     * @group item-category-tests
     *
     * @test
     */
    public function can_delete_a_new_item_category()
    {
        $itemCategory = factory(Department::class)->create();

        $this->delete('departments/' . $itemCategory->getKey());

        $this->dontSeeInDatabase('departments', ['name' => $itemCategory->name]);
    }

    /**
     * @group item-category-tests
     *
     * @test
     */
    public function fails_when_deleting_non_existant_item_category()
    {
        $this->delete('departments/1');

        $this->assertResponseStatus(404);
    }

    /**
     * @group item-category-tests
     *
     * @test
     */
    public function can_edit_item_category()
    {
        $itemCategory = factory(Department::class)->create();

        $alteredName = $itemCategory->name . 'altered';
        $this->patch('departments/' . $itemCategory->getKey(), ['name' => $alteredName]);

        $this->assertEquals($alteredName, $itemCategory->fresh()->name);
    }

    /**
     * @group item-category-tests
     *
     * @test
     */
    public function delete_item_category_with_associated_items()
    {
        $itemCategory = factory(Department::class)->create();

        $item = factory(Item::class)->create([
            'department_id' => $itemCategory->getKey()
        ]);

        $itemCategory->items()->save($item);

        $this->delete('departments/' . $itemCategory->getKey(), ['force' => 'false']);

        $this->assertNotNull($itemCategory->fresh());
        $this->assertTrue($item->fresh()->exists());
        $this->assertResponseStatus(290);

        $this->delete('departments/' . $itemCategory->getKey(), ['force' => 'true']);

        $this->assertNull($itemCategory->fresh());
        $this->assertNull($item->fresh());
        $this->assertResponseStatus(200);
    }
}
