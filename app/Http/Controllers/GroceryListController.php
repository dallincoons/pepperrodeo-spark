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
        $user = \Auth::user();

        $grocerylists = $user->groceryLists()->latest()->get();

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

        JavaScript::put(['recipes' => $recipes->load('items.department')->keyBy('id')]);
        JavaScript::put(['departments' => Department::all()->keyBy('id')]);

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
        $grocerylist = GroceryListRepository::store($request->only(['title', 'items']));

        return response(['grocerylist' => $grocerylist->getKey()]);
    }

    /**
     * @param \App\Entities\GroceryList $grocerylist
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(GroceryList $grocerylist)
    {
        $recipes = \Auth::user()->recipes()->with('items')->get();

        \JavaScript::put(['grocerylist' => $grocerylist->load(['items', 'items.department', 'recipes'])]);
        \JavaScript::put(['recipes' => $recipes->load('items.department')->keyBy('id')]);
        \JavaScript::put(['departments' => Department::all()->keyBy('id')]);

        return view('grocerylists.show-grocery-list', compact('grocerylist'));
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Entities\GroceryList $grocerylist
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateGroceryListRequest $request, GroceryList $grocerylist)
    {
       GroceryListRepository::update($request->only(['title', 'items']), $grocerylist);

        return response(200);
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
