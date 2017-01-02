<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Baking',
            'Canned Goods',
            'Condiments',
            'Dairy',
            'Dry Goods',
            'Frozen',
            'Household Goods',
            'Meat',
            'Miscellaneous',
            'Produce',
            'Spices'
        ];

        foreach($categories as $category){
           App\Entities\Department::create([
                'name' => $category,
                'user_id' => 1
           ]);
        }
    }
}
