<?php

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
    public function add_a_new_item_category()
    {
        $itemCategory = factory(ItemCategory::class)->make();

        $this->post('departments', $itemCategory->toArray());

        $this->seeInDatabase('item_categories', ['name' => $itemCategory->name]);
    }

    /**
     * @group item-category-tests
     *
     * @test
     */
    public function can_delete_a_new_item_category()
    {
        $itemCategory = factory(ItemCategory::class)->create();

        $this->delete('departments/' . $itemCategory->getKey());

        $this->dontSeeInDatabase('item_categories', ['name' => $itemCategory->name]);
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
        $itemCategory = factory(ItemCategory::class)->create();

        $alteredName = $itemCategory->name . 'altered';
        $this->patch('departments/' . $itemCategory->getKey(), ['name' => $alteredName]);

        $this->assertEquals($alteredName, $itemCategory->fresh()->name);
    }
}
