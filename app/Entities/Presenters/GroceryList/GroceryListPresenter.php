<?php

namespace App\Entities\Presenters\GroceryList;

use App\Entities\Presenters\Present;
use App\PepperRodeo\GroceryLists\GroceryListPresention;
use Illuminate\Database\Eloquent\Collection;

class GroceryListPresenter extends Present
{
    protected $items;

    /**
     * @return $this
     */
    public function items()
    {
        $this->items = GroceryListPresention::build($this->entity)->items;

        return $this;
    }

    /**
     * @return Collection
     */
    public function byCategory()
    {
        $this->assertItemsSet();

        $this->items = $this->items->sortBy('category')->groupBy('category');

        return $this->items;
    }

    /**
     * @return Collection
     */
    public function byRecipe()
    {
        $this->assertItemsSet();

        $this->items = $this->items->sortBy('recipe')->groupBy('recipe');

        return $this->items;
    }

    /**
     * @return Collection
     */
    public function unSorted()
    {
        $this->assertItemsSet();

        return $this->items;
    }

    protected function assertItemsSet()
    {
        if(!$this->items instanceof Collection){
            throw new \PresenterException('items property is not. Call items method before any sorting methods');
        }
    }
}
