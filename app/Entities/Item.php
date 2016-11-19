<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Recipe;
use App\Entities\GroceryList;
use App\Entities\ItemCategory;

class Item extends Model
{
    protected $fillable = array('quantity', 'name', 'type', 'recipe_id', 'grocery_list_id', 'item_category_id', 'category', 'recipe');

    protected $appends = ['recipe_id', 'category', 'recipe_title'];

    public function recipe()
    {
        return $this->morphedByMany(Recipe::class, 'itemable');
    }

    public function groceryList()
    {
        return $this->morphedByMany(GroceryList::class, 'itemable');
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function getRecipeIdAttribute()
    {
        if($this->recipe()->first()){
            return $this->recipe()->first()->id;
        }

        return null;
    }

    public function getRecipeTitleAttribute()
    {
        if($this->recipe()->first()){
            return $this->recipe()->first()->title;
        }

        return null;
    }

    public function getCategoryAttribute()
    {
        if($this->item_category_id){
            return ItemCategory::find($this->item_category_id)->name;
        }

        return null;
    }
}
