<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RecipeCategorySeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(RecipeSeeder::class);
        $this->call(GroceryListSeeder::class);
    }
}
