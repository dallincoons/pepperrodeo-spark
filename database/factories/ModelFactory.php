<?php

use App\Entities\Item;
use App\Entities\Recipe;
use App\Entities\GroceryList;
use App\Entities\Department;
use App\Entities\RecipeCategory;
use App\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Item::class, function (Faker\Generator $faker) {
    $user = \Auth::user() ?: User::find(1);
    if(!$user->departments->count()){
        \Auth::user()->departments()->create([
            'name' => 'Baking'
        ]);
    }

    return [
        'quantity' => $faker->randomNumber(2),
        'name' => $faker->word,
        'type' => collect(['pkg', 'can', 'bottle', 'jug'])->random(),
        'isCheckedOff' => 0,
        'remember_token' => str_random(10),
        'department_id' => $user->fresh()->departments()->inRandomOrder()->first()->getKey()
    ];
});

$factory->define(Department::class, function(Faker\Generator $faker){
    return [
        'name' => $faker->word,
        'user_id' => \Auth::user()->getKey()
    ];
});

$factory->define(RecipeCategory::class, function (Faker\Generator $faker){
    return [
        'user_id' => \Auth::user()->getKey(),
        'name' => $faker->word
    ];
});

$factory->define(Recipe::class, function (Faker\Generator $faker){
    return [
        'title' => $faker->text(15),
        'user_id' => User::firstOrCreate(['name' => 'les', 'email' => 'donkeyballs@hotmail.com', 'password' => 'password123'])->getKey(),
        'directions' => $faker->paragraph,
        'recipe_category_id' => RecipeCategory::firstOrCreate(['name' => $faker->word, 'user_id' => \Auth::user() ? \Auth::user()->getKey() : 1])->getKey()
    ];
});

$factory->define(GroceryList::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'user_id' => User::firstOrCreate(['name' => 'les', 'email' => 'donkeyballs@hotmail.com', 'password' => 'password123'])->getKey()
    ];
});
