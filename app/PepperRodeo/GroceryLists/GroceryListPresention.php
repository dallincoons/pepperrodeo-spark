<?php namespace App\PepperRodeo\GroceryLists;

use App\Entities\GroceryList;
use Illuminate\Database\Eloquent\Collection;
use App\Entities\Item;

class GroceryListPresention
{
    protected $items;

    /**
     * @param $grocerylist
     * @return \App\Entities\GroceryList
     */
    public function build($grocerylist)
    {
        $this->items = $grocerylist->items;
        $presenter = $this->createListPresenter($grocerylist);

        $this->mapNameToLowerCase();
        $this->items = $this->items->keyBy('id');

        foreach($this->items as $item)
        {
            $likeItems = $this->findLikeItems($item);

            foreach($this->combineLikeItems($likeItems) as $combinedItem)
            {
                $presenter->storeItem($combinedItem);
            }
        }

        $presenter['id'] = $grocerylist->id;

        return $presenter;
    }

    protected function mapNameToLowerCase()
    {
        return $this->items->map(function($item, $key){
            $item->name  = strtolower($item->name);
            return $item;
        });
    }

    /**
     * @param $item
     * @return mixed
     */
    protected function findLikeItems($item)
    {
        $items = $this->items;

        $likeItems = $items->filter(function ($value, $key) use ($item) {
                return strtolower($value->name) === strtolower($item->name);
        });
        return $likeItems;
    }

    /**
     * @param $likeItems
     *
     * @return Collection
     */
    protected function combineLikeItems($likeItems)
    {
        $newCollection = new Collection();
        if(is_object($likeItems->first())) {
            $newCollection->add(new Item([
                'name' => $likeItems->first()->name,
                'quantity' => $likeItems->sum('quantity'),
                'type' => $likeItems->first()->type,
                'item_category_id' => $likeItems->first()->item_category_id,
                'category' => $likeItems->first()->category,
                'recipe' => $likeItems->first()->recipe_title
            ]));
        }

        foreach ($likeItems->pluck('id') as $id) {
            $this->items->forget($id);
        }
        return $newCollection;
    }

    protected function createListPresenter($list)
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
