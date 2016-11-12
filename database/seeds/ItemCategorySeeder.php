<?php

use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
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
           \App\ItemCategory::create([
                'name' => $category
           ]);
        }
    }
}
