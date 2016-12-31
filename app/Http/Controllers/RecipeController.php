<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\RecipeCategory;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;
use App\Entities\Recipe;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //should we toggle delete functionality
        if(parse_url($request->url())['path'] == '/recipe/delete'){
            \JavaScript::put(['showCheckBoxes' => true]);
        }

        $recipesWithCategories = RecipeRepository::recipesWithCategories();

        return view('recipes.all-recipes', compact('recipesWithCategories'));
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
        \JavaScript::put(['itemCategories' => \Auth::user()->itemCategories->toArray()]);

        return view('recipes.create-recipe', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRecipeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeRequest $request)
    {
        try {
            $category = explode(',', $request->category);
            $recipe   = RecipeRepository::store([
                'title' => $request->title,
                'directions' => $request->directions,
                'category' => [
                    'id' => $category[0],
                    'name' => $category[1]
                ],
                'recipeFields' => $request->recipeFields ?: []
            ]);
        }catch(\Exception $e){
            abort(422, $e->getMessage());
        }

        return redirect('/recipe/' . $recipe->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param  Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        $listsWithoutRecipe = GroceryList::ListsWithoutRecipe($recipe);

        \JavaScript::put('recipe', $recipe->toArray());
        \JavaScript::put('grocerylists', GroceryList::ListsWithoutRecipe($recipe));

        return view('recipes.single-recipe', compact('recipe', 'listsWithoutRecipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        $categories = \Auth::user()->recipeCategories()->get();

        \JavaScript::put(['categories' => $categories->toArray()]);
        \JavaScript::put(['itemCategories' => \Auth::user()->itemCategories->toArray()]);
        \JavaScript::put(['selectedCategory' => [$recipe->category->getKey(), $recipe->category->name]]);
        \JavaScript::put(['recipeItems' => $recipe->items->toArray()]);

        return view('recipes.edit-single', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
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
     * @param  Recipe  $recipe
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

        return redirect('/recipe/delete');
    }
}
