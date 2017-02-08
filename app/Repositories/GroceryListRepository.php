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

        foreach($listData['items'] as $item)
        {
            $items[] = Item::create([
                'name' => $item['name'],
                'type' => $item['type'],
                'quantity' => $item['quantity'],
                'department_id' => $item['department_id']
            ]);
        }

        $grocerylist->items()->saveMany($items);

        return $grocerylist;
    }

    public static function update($data, $grocerylist)
    {
        if($item = data_get($data, 'title', null)) {
            $grocerylist->title = $item;
        }

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
