<?php

use App\Item;
use App\Recipe;
use App\GroceryList;
use App\ItemCategory;
use App\RecipeCategory;

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$cnt = ItemCategory::count();
$randIndex = rand(0, $cnt-1);

$factory->define(App\Item::class, function (Faker\Generator $faker) use($randIndex) {
    return [
        'quantity' => $faker->randomNumber(2),
        'name' => $faker->word,
        'type' => collect(['pkg', 'can', 'bottle', 'jug'])->random(),
        'isCheckedOff' => 0,
        'remember_token' => str_random(10),
        'item_category_id' => ItemCategory::inRandomOrder()->get()->first()->getKey()
    ];
});

$factory->define(RecipeCategory::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\Recipe::class, function (Faker\Generator $faker){
    return [
        'title' => $faker->text(15),
        'user_id' => App\User::all()->random()->id,
        'directions' => $faker->paragraph,
        'recipe_category_id' => RecipeCategory::first()->getKey()
    ];
});

$factory->define(App\GroceryList::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'user_id' => App\User::all()->random()->id
    ];
});

