<?php namespace App\PepperRodeo\GroceryLists;

use App\Entities\GroceryList;
use Illuminate\Database\Eloquent\Collection;
use App\Entities\Item;

class GroceryListPresention
{
    protected static $items;

    /**
     * @param GroceryList $grocerylist
     * @return \App\Entities\GroceryList
     */
    public static function build(GroceryList $grocerylist)
    {
        self::$items = self::mapNamesToLowerCase($grocerylist->items)->keyBy('id');

        $presenter = self::createListPresenter($grocerylist);
        $presenter->storeMany(self::combinedItems());

        return $presenter;
    }

    protected static function mapNamesToLowerCase($collection)
    {
        return $collection->map(function($item){
            $item->name  = strtolower($item->name);
            return $item;
        });
    }

    /**
     * @param $item
     * @return mixed
     */
    protected static function findLikeItems($item)
    {
        $items = self::$items;

        $likeItems = $items->filter(function ($value) use ($item) {
                return strtolower($value->name) === strtolower($item->name);
        });
        return $likeItems;
    }

    /**
     * @return Collection
     */
    protected static function combinedItems()
    {
        $newCollection = new Collection();

        foreach(self::$items as $item)
        {
            $likeItems = self::findLikeItems($item);

            if(is_object($likeItems->first())) {
                $newCollection->add(self::newItem($likeItems));
            }

            foreach ($likeItems->pluck('id') as $id) {
                self::$items->forget($id);
            }
        }

        return $newCollection;
    }

    protected static function newItem($items)
    {
        return (new Item([
            'name' => $items->first()->name,
            'quantity' => $items->sum('quantity'),
            'type' => $items->first()->type,
            'item_category_id' => $items->first()->item_category_id,
            'category' => $items->first()->category,
            'recipe' => $items->first()->recipe_title
        ]));
    }

    protected static function createListPresenter($list)
    {
        $presenter = new GroceryList([
            'title' => $list->title,
        ]);

        foreach($list->recipes as $recipe)
        {
            $presenter->recipes->add($recipe);
        }

        return $presenter;
    }
}
