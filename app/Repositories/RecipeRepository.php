<?php
namespace App\Repositories;

use App\Entities\RecipeCategory;
use App\Entities\Recipe;
use App\Entities\Item;

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
        $category = $recipeData['category'];

        $recipe->title = $recipeData['title'];
        $recipe->directions = $recipeData['directions'];

        if($category['id'] == -1 || !RecipeCategory::exists($category['id'])){
            $category = RecipeCategory::create([
                'user_id' => \Auth::user()->getKey(),
                'name' => $category['name']
            ]);
        }
        $recipe->category()->associate($category['id']);

        if($recipe->isDirty()){
            $recipe->save();
        }
    }

    public static function updateRecipeItems($recipe, $recipeFields)
    {
        $recipeFields = collect($recipeFields);

        foreach( $recipe->items as $item )
        {
            if( $itemJson = $recipeFields->where('id', $item->id)->first() ){

                $item->quantity = $itemJson['quantity'];
                $item->type = $itemJson['type'];
                $item->name = $itemJson['name'];
                $item->department_id = $itemJson['department_id'];

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

    public static function store($recipeData)
    {
        $recipeFields = data_get($recipeData, 'recipeFields', []);
        if(!count($recipeFields)){
            throw new \Exception('Recipe must contain at least one item');
        }
        $categoryData = $recipeData['category'];
        $category = RecipeCategory::findOrNew($categoryData['id']);
        if(!$category->getKey()){
            $category->populate($recipeData)->save();
        }

        $recipe = Recipe::create([
            'user_id' => \Auth::user()->getKey(),
            'title' => $recipeData['title'],
            'directions' => $recipeData['directions'],
            'recipe_category_id' => $category->getKey()
        ]);
        $recipe->category()->associate($category->getKey());

        $recipe->populateItems($recipeFields)->save();

        return $recipe;
    }

    protected static function categoryNotExist($category)
    {
        return $category['id'] == -1 || !RecipeCategory::exists($category['id']);
    }
}
