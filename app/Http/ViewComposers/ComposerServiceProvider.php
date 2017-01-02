<?php

namespace App\Http\ViewComposers;

use App\Entities\Department;
use App\Entities\RecipeCategory;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer(['recipes.create-recipe',
                         'recipes.edit-single',
                         'grocerylists.create-grocery-list',
                         'grocerylists.show-grocery-list'
                         ], function($view){
            $departments = Department::all();
            $view->with('departments', $departments);
        });

        \View::composer(['recipes.show-all-recipes'], function($view){
            $recipeCategories = RecipeCategory::all()->pluck('name', 'id');
            $view->with('recipeCategories', $recipeCategories);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
