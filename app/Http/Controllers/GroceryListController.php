<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroceryListRequest;
use App\Http\Requests\UpdateGroceryListRequest;
use App\Repositories\GroceryListRepository;
use Illuminate\Http\Request;
use App\Entities\GroceryList;
use App\PepperRodeo\GroceryLists\GroceryListPresention;
use App\Entities\Department;
use JavaScript;

class GroceryListController extends Controller
{
    protected $listBuilder;

    public function __construct(GroceryListPresention $listBuilder)
    {
        $this->listBuilder = $listBuilder;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //should we toggle delete functionality
        if(parse_url($request->url())['path'] == '/grocerylist/delete'){
            \JavaScript::put(['showCheckBoxes' => true]);
        }

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
        JavaScript::put(['categories' => Department::all()->keyBy('id')]);

        return view('grocerylists.create-grocery-list', compact('recipes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreGroceryListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroceryListRequest $request)
    {
        $grocerylist = GroceryListRepository::store([
            'title' => $request->title,
            'items' => $request->items,
            'recipeIds' => $request->recipeIds
        ]);

        return redirect('/grocerylist/' . $grocerylist->getKey());
    }

    /**
     * @param \App\Entities\GroceryList $grocerylist
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(GroceryList $grocerylist)
    {
        $recipes = \Auth::user()->recipes()->with('items')->get();

        \JavaScript::put(['items' =>  $grocerylist->items]);
        \JavaScript::put(['addedRecipes' => $grocerylist->recipes]);
        \JavaScript::put(['title' => $grocerylist->title]);
        \JavaScript::put(['recipes' => $recipes->keyBy('id')]);
        \JavaScript::put(['categories' => Department::all()->keyBy('id')]);

        return view('grocerylists.show-grocery-list', compact('grocerylist'));
    }

    /**
     * @param \App\Entities\GroceryList $grocerylist
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        abort(404);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Entities\GroceryList $grocerylist
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateGroceryListRequest $request, GroceryList $grocerylist)
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

        return redirect('/grocerylist/delete');
    }
}
