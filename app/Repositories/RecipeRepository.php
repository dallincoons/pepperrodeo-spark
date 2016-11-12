<?php
namespace App\Repositories;

use App\Recipe;
use App\Item;

class RecipeRepository
{
    public static function recipesWithCategories()
    {
        $recipesWithCategories = [];
        foreach(Recipe::where('user_id', \Auth::user()->getKey())->with('category')->get() as $recipe)
        {
            $category = $recipe->category->name;
            if(!isset($recipesWithCategories[$category])){
                $recipesWithCategories[$category] = [];
            }
            array_push($recipesWithCategories[$category], $recipe);
        }

        return $recipesWithCategories;
    }

    public static function updateRecipe($recipe, $recipeData)
    {
        $recipe->title = $recipeData['title'];
        $recipe->recipe_category_id = $recipeData['recipe_category_id'];
        $recipe->directions = $recipeData['directions'];

        if($recipe->isDirty()){
            $recipe->save();
        }
    }

    public static function updateRecipeItems($recipe, $recipeFields)
    {
        $recipeFields = collect($recipeFields);

        foreach( $recipe->items as $item )
        {
            if( $itemJson = $recipeFields->whereLoose('id', $item->id)->first() ){

                $item->quantity = $itemJson['quantity'];
                $item->type = $itemJson['type'];
                $item->name = $itemJson['name'];
                $item->item_category_id = $itemJson['item_category_id'];

                if($item->isDirty()){
                    $item->save();
                }
            }else{
                $item->delete();
            }
        }

        foreach($recipeFields as $itemJson)
        {
            if(!$recipe->items->contains($itemJson['id'])){
                $item = Item::create($itemJson);
                $recipe->items()->save($item);
            }
        }
    }
}
