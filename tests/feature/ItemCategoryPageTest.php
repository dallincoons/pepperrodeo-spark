<?php

use App\Entities\ItemCategory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemCategoryPageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @group item-category-page-tests
     *
     * @test
     */
    public function categories_can_be_seen()
    {
        $category1 = factory(ItemCategory::class)->create();
        $category2 = factory(ItemCategory::class)->create();

        $this->visit('/departments');

        $this->see($category1->name);
        $this->see($category2->name);
    }
}
