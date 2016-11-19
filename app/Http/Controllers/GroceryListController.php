<?php

namespace App\Http\Controllers;

use App\Repositories\GroceryListRepository;
use Illuminate\Http\Request;
use App\GroceryList;
use App\PepperRodeo\GroceryLists\GroceryListPresenterBuilder;
use App\ItemCategory;
use App\Item;
use JavaScript;

class GroceryListController extends Controller
{
    protected $listBuilder;

    public function __construct(GroceryListPresenterBuilder $listBuilder)
    {
        $this->listBuilder = $listBuilder;
    }

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
        JavaScript::put(['categories' => ItemCategory::all()->keyBy('id')]);

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
        $grocerylist = GroceryListRepository::store([
            'title' => $request->title,
            'items' => $request->items,
            'recipeIds' => $request->recipeIds
        ]);

        return redirect('/grocerylist/' . $grocerylist->getKey());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(GroceryList $grocerylist, Request $request)
    {
        if(!$request->get('sortBy') || $request->get('sortBy') == 'item') {
            $grocerylist = $this->listBuilder->build($grocerylist)->byCategory();
        }

        if($request->get('sortBy') == 'recipe'){
            $grocerylist = $this->listBuilder->build($grocerylist)->byRecipe();
        }

        return view('grocerylists.single-grocery-list', compact('grocerylist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(GroceryList $grocerylist, Request $request)
    {
        $recipes = \Auth::user()->recipes()->with('items')->get();

        \JavaScript::put(['items' =>  $grocerylist->items]);
        \JavaScript::put(['addedRecipes' => $grocerylist->recipes]);
        \JavaScript::put(['title' => $grocerylist->title]);
        \JavaScript::put(['recipes' => $recipes->keyBy('id')]);
        \JavaScript::put(['categories' => ItemCategory::all()->keyBy('id')]);

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
       GroceryListRepository::update([
        'items' => $request->items,
        'title' => $request->title
       ], $grocerylist);

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
        $ids = [];

        foreach(\Request::input('lists') as $list)
        {
            $ids[] = json_decode($list)->id;
        }

        GroceryList::destroy($ids);

        return redirect('/grocerylist');
    }
}
