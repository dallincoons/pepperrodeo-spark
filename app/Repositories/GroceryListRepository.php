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

        $grocerylist = GroceryList::create(['user_id' => \Auth::user()->getKey(), 'title' => $listData['title']]);

        foreach(Item::findMany(collect($listData['items'])->pluck('id')) as $item)
        {
            $items[] = $item;
        }

        foreach($listData['items'] as $itemJson)
        {
            if(!$itemJson['id'] || $itemJson < 1){
                $items[] = Item::create($itemJson);
            }
        }
        $grocerylist->items()->saveMany($items);
        foreach(explode(',', $listData['recipeIds']) as $recipeId)
        {
            $grocerylist->recipes()->save(Recipe::find($recipeId));
        }

        return $grocerylist;
    }
}
