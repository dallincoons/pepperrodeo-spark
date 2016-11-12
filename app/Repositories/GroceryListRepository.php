<?php

namespace App\Repositories;

use App\GroceryList;
use App\Item;
use App\Recipe;

class GroceryListRepository
{
    public static function store($listData)
    {
        $items = [];

        $grocerylist = GroceryList::create(['user_id' => \Auth::user()->getKey(), 'title' => $listData['list']]);

        foreach($listData['items'] as $itemJson)
        {
            $items[] = Item::create($itemJson);
        }
        $grocerylist->items()->saveMany($items);
        foreach(explode(',', $listData['recipeIds']) as $recipeId)
        {
            $grocerylist->recipes()->save(Recipe::find($recipeId));
        }

        return $grocerylist;
    }
}
