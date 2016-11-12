<?php


namespace App\PepperRodeo\GroceryLists;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\ItemCategory;

class GroceryListPresenter extends Model
{
    protected $items;

    protected $fillable = ['title', 'items', 'recipes'];

    public function __construct()
    {
        $this->items = new Collection;
    }

    function getItemsAttribute()
    {
        return collect($this->items);
    }

    public function addItem($item)
    {
        $this->items->add($item);

        return $this->items;
    }

    public function byCategory()
    {
        $this->items = $this->items->groupBy('category');

        return $this;
    }
}
