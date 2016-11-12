<?php namespace App\PepperRodeo\GroceryLists;

use Illuminate\Database\Eloquent\Collection;
use App\ItemCategory;
use App\Item;

class GroceryListPresenterBuilder
{
    protected $items;

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
                $presenter->addItem($combinedItem);
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
     * @param $items
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
     * @param $items
     * @param $likeItems
     * @param $newCollection
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
                'category' => $likeItems->first()->category
            ]));
        }

        foreach ($likeItems->pluck('id') as $id) {
            $this->items->forget($id);
        }
        return $newCollection;
    }

    protected function createListPresenter($list)
    {
        //@todo don't know why I can't set these fields in constructor
        $presenter = new GroceryListPresenter([
            'title' => $list->title,
            'recipes' => $list->recipes
        ]);

        $presenter->title = $list->title;
        $presenter->recipes = $list->recipes;

        return $presenter;
    }
}
