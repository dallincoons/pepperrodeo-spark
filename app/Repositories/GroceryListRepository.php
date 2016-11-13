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

    public static function update($data, $grocerylist)
    {
        $itemIds = collect($data['items'])->where('id', '!=', -1)->pluck('id');

        $newItems = collect($data['items'])->where('id', -1);

        foreach($newItems as $itemJson)
        {
            $item = Item::create($itemJson);
            $itemIds->push($item->id);
        }

        $grocerylist->items()->sync($itemIds->toArray());

        $grocerylist->title = $data['title'];

        $grocerylist->save();

        return $grocerylist;
    }
}
