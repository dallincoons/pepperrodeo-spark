<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
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
        \JavaScript::put('grocerylists', GroceryList::take(10)->get());

        $recipes = \Auth::user()->recipes()->latest()->get();

        \Javascript::put(['recipes' => $recipes->toArray()]);

        return view('recipes.all-recipes');
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
        \JavaScript::put(['departments' => \Auth::user()->departments->toArray()]);

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
            $data = $request->only(['title', 'directions', 'recipeFields']);
            data_set($data, 'category', [
                'id' => $category[0],
                'name' => $category[1]
            ]);

            $recipe   = RecipeRepository::store($data);
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
        \JavaScript::put(['departments' => \Auth::user()->departments->toArray()]);
        \JavaScript::put(['selectedCategory' => [$recipe->category->getKey(), $recipe->category->name]]);
        \JavaScript::put(['recipeItems' => $recipe->items->toArray()]);

        return view('recipes.edit-single', compact('recipe'));
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $category = explode(',', $request->category);
        $data = $request->only(['title', 'directions']);
        $data['category'] = [
            'id' => $category[0],
            'name' => $category[1]
        ];

        RecipeRepository::updateRecipe($recipe, $data);

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

        return response('recipe deleted');
    }

    /**
     * Remove the specified resources from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple()
    {
        Recipe::destroy(\Request::input('recipeIds'));

        return response('recipes deleted');
    }
}
