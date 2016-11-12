<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Item;
use App\Recipe;
use App\User;

class ItemTest extends TestCase
{
    use DatabaseTransactions;

    private $Item;
    private $Recipe;

    public function setUp()
    {
        parent::setUp();
//
//        factory(User::class)->create();
//        $this->Recipe = factory(Recipe::class)->create();
//        $this->Item = factory(Item::class)->create();
    }

    /**
     * @test
     */
    public function example()
    {

    }
}
