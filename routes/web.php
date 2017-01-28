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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function(){

    Route::get('recipe/categories', 'RecipeCategoryController@index');
    Route::get('recipe/categories/{recipecategory}', 'RecipeCategoryController@show');
    Route::delete('recipe/categories/{recipecategory}', 'RecipeCategoryController@destroy');
    Route::post('recipe/categories', 'RecipeCategoryController@store');
    Route::patch('recipe/categories/{recipecategory}', 'RecipeCategoryController@update');

    Route::delete('recipe/deleteMultiple', 'RecipeController@destroyMultiple');
    Route::get('recipe/delete', 'RecipeController@index');
    Route::resource('recipe', 'RecipeController');

    Route::post('grocerylist/{grocerylist}/recipe/{recipe}', 'GroceryListRecipeController@store');

    Route::post('grocerylist/{grocerylist}/item', 'GroceryListItemController@store');
    Route::post('grocerylistitem/remove', 'GroceryListItemController@remove');
    Route::patch('grocerylistitem/edit/{item}', 'GroceryListItemController@update');

    Route::get('grocerylist/delete', 'GroceryListController@index');
    Route::delete('grocerylist/deleteMultiple', 'GroceryListController@destroyMultiple');
    Route::post('/grocerylist/{grocerylist}/add', 'RecipeListController@store');
    Route::resource('grocerylist', 'GroceryListController', ['except' => 'edit']);

    Route::resource('departments', 'DepartmentController');

    Route::get('contact',function(){
        return view('contact.contact');
    });
});
