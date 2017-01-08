<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    /**
     * @group register-tests
     *
     * @test
     */
    public function register_new_user_and_assert_default_departments_are_created()
    {
        $this->post('http://pepperrodeo.dev/register', [
            'name' => 'Dallin',
            'email' => 'unique@hotmail.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $user = User::where('email', 'unique@hotmail.com')->first();

        $this->assertGreaterThan(0, $user->recipeCategories->count());
        $this->assertGreaterThan(0, $user->departments->count());
    }
}
