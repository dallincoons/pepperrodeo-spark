<?php

namespace App\Entities;

use App\Traits\Itemable;
use App\Traits\Copyable;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Presenters\GroceryList\GroceryListPresenter;
use App\User;
use App\Traits\Presentable;

class GroceryList extends Model
{
    use Itemable, Copyable, Presentable;

    private $foreignKey = 'grocery_list_id';

    protected $fillable = array('user_id', 'title');
    protected $presenter = GroceryListPresenter::class;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->morphToMany(Item::class, 'itemable');
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }

    public function addRecipe($recipe)
    {
        $this->recipes()->attach($recipe->id);
        $this->items()->saveMany($recipe->items);
    }

    public function removeRecipe($recipe)
    {
        $this->recipes()->detach($recipe);
    }

    public function checkOffItem($item)
    {
        $item->isCheckedOff = 1;

        $item->save();
    }

    public function removeItem($item)
    {
        $item->delete();
    }
}
