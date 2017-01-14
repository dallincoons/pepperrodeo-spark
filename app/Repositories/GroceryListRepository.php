<?php

namespace App\Repositories;

use App\Entities\GroceryList;
use App\Entities\Item;
use App\Entities\Recipe;
use Illuminate\Support\Collection;

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
        foreach(collect($listData['items'])->where('id', '<', 0) as $item)
        {
            $items[] = Item::create($item);
        }

        $grocerylist->items()->saveMany($items);

        return $grocerylist;
    }

    public static function update($data, $grocerylist)
    {
        $itemIds = collect($data['items'])->where('id', '>', 0)->pluck('id');

        $newItems = collect($data['items'])->where('id', '<', 0);

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

    /**
     * @param $list
     * @param $recipe
     * @return mixed
     */
    public static function addRecipe($list, $recipeIds)
    {
        $grocerylist = GroceryList::findOrFail($list);

        $recipeIds = ($recipeIds instanceof Collection) ? $recipeIds : collect($recipeIds);

        foreach($recipeIds as $recipeId)
        {
            $grocerylist->addRecipe(Recipe::findOrFail($recipeId));
        }
    }
}
