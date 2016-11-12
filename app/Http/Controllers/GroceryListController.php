<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\GroceryList;
use App\PepperRodeo\GroceryLists\GroceryListPresenterBuilder;
use App\Recipe;
use JavaScript;

class GroceryListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        $grocerylists = $user->groceryLists;

        return view('grocerylists.all-grocery-lists', compact('grocerylists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $recipes = \Auth::user()->recipes()->with('items')->get();

        JavaScript::put(['recipes' => $recipes->keyBy('id')]);

        return view('grocerylists.create-grocery-list', compact('recipes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = [];

        $grocerylist = GroceryList::create(['user_id' => \Auth::user()->getKey(), 'title' => $request->title]);

        foreach($request->input('items') as $itemJson)
        {
            $items[] = Item::create($itemJson);
        }

        $grocerylist->items()->saveMany($items);
        foreach($request->recipeIds as $recipeId)
        {
            $grocerylist->recipes()->save(Recipe::find($recipeId));
        }

        return redirect('/grocerylist/' . $grocerylist->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(GroceryList $grocerylist, GroceryListPresenterBuilder $listBuilder)
    {
        $grocerylist = $listBuilder->build($grocerylist)->byCategory();

        return view('grocerylists.single-grocery-list', compact('grocerylist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(GroceryList $grocerylist)
    {
        $recipes = \Auth::user()->recipes()->with('items')->get();

        JavaScript::put(['items' => $grocerylist->items]);
        JavaScript::put(['addedRecipes' => $grocerylist->recipes]);
        JavaScript::put(['recipes' => $recipes->keyBy('id')]);

        return view('grocerylists.edit-grocery-list', compact('grocerylist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @PUT/PATCH
     */
    public function update(Request $request, GroceryList $grocerylist)
    {
        $itemIds = collect($request->input('items'))->pluck('id');

        $grocerylist->items()->sync($itemIds->toArray());

        return redirect('/grocerylist/' . $grocerylist->getKey());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroceryList $grocerylist)
    {
        $grocerylist->delete();

        return redirect('/grocerylist');
    }

    /**
     * Remove the specified resources from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple()
    {
        GroceryList::destroy(\Request::input('listIds'));

        return redirect('/grocerylist');
    }
}
