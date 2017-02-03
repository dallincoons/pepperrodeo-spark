<?php

use App\Entities\Department;
use App\Entities\Item;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @group department-tests
     *
     * @test
     */
    public function categories_can_be_seen()
    {
        $department1 = factory(Department::class)->create();
        $department2 = factory(Department::class)->create();

        $response = $this->get('/departments');

        $response->assertSee($department1->name);
        $response->assertSee($department2->name);
        $response->assertStatus(200);
    }

    /**
     * @group department-tests
     *
     * @test
     */
    public function add_a_new_department()
    {
        $department = factory(Department::class)->make();

        $this->post('departments', $department->toArray());

        $this->assertDatabaseHas('departments', ['name' => $department->name]);
    }

    /**
     * @group department-tests
     *
     * @test
     */
    public function can_delete_a_new_department()
    {
        $department = factory(Department::class)->create();

        $this->delete('departments/' . $department->getKey());

        $this->assertDatabaseMissing('departments', ['name' => $department->name]);
    }

    /**
     * @group department-tests
     *
     * @test
     */
    public function fails_when_deleting_non_existant_department()
    {
        $response = $this->delete('departments/1');

        $response->assertStatus(404);
    }

    /**
     * @group department-tests
     *
     * @test
     */
    public function can_edit_department()
    {
        $department = factory(Department::class)->create();

        $alteredName = $department->name . 'altered';
        $this->patch('departments/' . $department->getKey(), ['name' => $alteredName]);

        $this->assertEquals($alteredName, $department->fresh()->name);
    }

    /**
     * @group department-tests
     *
     * @test
     */
    public function delete_department_with_associated_items()
    {
        $department = factory(Department::class)->create();

        $item = factory(Item::class)->create([
            'department_id' => $department->getKey()
        ]);

        $department->items()->save($item);

        $response = $this->delete('departments/' . $department->getKey());

        $this->assertNull($department->fresh());
        $this->assertNull($item->fresh());
        $response->assertStatus(200);
    }
}
