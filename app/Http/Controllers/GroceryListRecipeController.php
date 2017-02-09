<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\Recipe;
use Illuminate\Http\Request;

class GroceryListRecipeController extends Controller
{
    public function store(Request $request, GroceryList $grocerylist)
    {
        $recipeIds = is_array($request->recipes) ? $request->recipes : [$request->recipes];

        foreach($recipeIds as $recipeId)
        {
            if($recipe = Recipe::find($recipeId)){
                $grocerylist->addRecipe($recipe);
            }
        }

        return response('recipe added');
    }
}
