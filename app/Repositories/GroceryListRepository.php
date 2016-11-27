<?php

namespace App\Repositories;

use App\Entities\GroceryList;
use App\Entities\Item;
use App\Entities\Recipe;

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
        foreach(explode(',', $listData['recipeIds']) as $recipeId)
        {
            if($recipeId) {
                $grocerylist->recipes()->save(Recipe::find($recipeId));
            }
        }

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
    public static function addRecipe($list, $recipe)
    {
        $grocerylist = GroceryList::findOrFail($list);

        $recipe = Recipe::findOrFail($recipe);

        $grocerylist->addRecipe($recipe);

        $listsWithoutRecipe = GroceryList::ListsWithoutRecipe($recipe);

        return $listsWithoutRecipe;
    }
}
