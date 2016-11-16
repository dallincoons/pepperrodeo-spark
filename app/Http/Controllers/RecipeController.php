<?php

namespace App\Http\Controllers;

use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;
use App\Recipe;
use App\Item;
use App\Http\Requests\CreateRecipeRequest;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipesWithCategories = RecipeRepository::recipesWithCategories();

        return view('recipes.show-all-recipes', compact('recipesWithCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \Auth::user()->recipeCategories()->get();

        \JavaScript::put(['categories' => $categories->toArray()]);

        return view('recipes.add-recipe', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = explode(',', $request->category);
        $recipe = RecipeRepository::store([
            'title' => $request->title,
            'directions' => $request->directions,
            'category' => [
                'id' => $category[0],
                'name' => $category[1]
            ],
            'recipeFields' => $request->recipeFields ?: []
        ]);

        return redirect('/recipe/' . $recipe->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        $listsWithoutRecipe = \Auth::user()->groceryLists->filter(function($grocerylist, $key) use($recipe){
            return($grocerylist->recipes()->where('id', $recipe->getKey())->count() === 0);
        });

        \JavaScript::put('recipe_id', $recipe->id);

        return view('recipes.single-recipe', compact('recipe', 'listsWithoutRecipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        $categories = \Auth::user()->recipeCategories()->get();

        \JavaScript::put(['categories' => $categories->toArray()]);
        \JavaScript::put(['selectedCategory' => [$recipe->category->getKey(), $recipe->category->name]]);
        \JavaScript::put(['recipeItems' => $recipe->items->toArray()]);

        return view('recipes.edit-single', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        $category = explode(',', $request->category);
        RecipeRepository::updateRecipe($recipe, [
            'title' => $request->title,
            'category' => [
                'id' => $category[0],
                'name' => $category[1]
            ],
            'directions' => $request->directions
        ]);

        RecipeRepository::updateRecipeItems($recipe, $request->input('recipeFields'));

        return redirect('/recipe/' . $recipe->getKey());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect('/recipe');
    }

    /**
     * Remove the specified resources from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple()
    {
        $ids = [];

        foreach(\Request::input('recipeIds') as $list)
        {
            $ids[] = json_decode($list)->id;
        }

        Recipe::destroy($ids);

        return redirect('/recipe');
    }
}
