<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\Item;
use App\Http\Requests\StoreGroceryListItemRequest;
use App\Http\Requests\UpdateGroceryListItemRequest;
use Illuminate\Http\Request;

class GroceryListItemController extends Controller
{
    public function store(StoreGroceryListItemRequest $request, GroceryList $grocerylist)
    {
        $itemData = $request->only(['name', 'type', 'quantity', 'department_id']);

        $grocerylist->items()->create($itemData);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Entities\Item $item
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateGroceryListItemRequest $request, Item $item)
    {
        $item->update(array_filter($request->all()));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        Item::findOrFail($request->itemIds);
        $grocerylist = GroceryList::findOrFail($request->grocerylist);

        $grocerylist->items()->detach($request->itemIds);
    }
}
