<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

Route::group(['middleware' => ['web', 'auth']], function(){

    Route::delete('recipe/deleteMultiple', 'RecipeController@destroyMultiple');
    Route::get('recipe/delete', 'RecipeController@index');
    Route::resource('recipe', 'RecipeController');

    Route::delete('grocerylist/deleteMultiple', 'GroceryListController@destroyMultiple');
    Route::get('/grocerylist/{grocerylist}/add/{recipe}', 'RecipeListController@store');
    Route::resource('grocerylist', 'GroceryListController');

    Route::resource('recipecategory', 'RecipeCategoryController');
});
