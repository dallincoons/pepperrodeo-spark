<?php

namespace App\Http\Controllers;

use App\Entities\GroceryList;
use App\Entities\Item;
use Illuminate\Http\Request;

class GroceryListItemController extends Controller
{
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
