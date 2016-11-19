<?php

namespace App\Entities\Presenters\GroceryList;

use App\Entities\Presenters\Present;
use App\PepperRodeo\GroceryLists\GroceryListPresenterBuilder;

class GroceryListPresenter extends Present
{
    public function items()
    {
        $this->items = \App::make(GroceryListPresenterBuilder::class)->build($this->entity);

        return $this->items;
    }

    public function byCategory()
    {
        $this->items = $this->items->groupBy('category');

        return $this;
    }

    public function byRecipe()
    {
        $this->items = $this->items->groupBy('recipe');

        return $this;
    }
}
