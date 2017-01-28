<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\Recipe;
use Illuminate\Http\Request;

class GroceryListRecipeController extends Controller
{
    public function store(GroceryList $grocerylist, Recipe $recipe)
    {
        $grocerylist->addRecipe($recipe);

        return response('recipe added');
    }
}
