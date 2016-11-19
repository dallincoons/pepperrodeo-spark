<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Item;
use App\Entities\RecipeCategory;
use App\Traits\Itemable;
use App\Traits\Copyable;
use App\Entities\GroceryList;

class Recipe extends Model
{
    use Itemable, Copyable;

    public $timestamps = true;
    private $foreignKey = 'recipe_id';

    protected $fillable = array('user_id', 'title', 'directions');

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->morphToMany(Item::class, 'itemable');
    }

    public function category()
    {
        return $this->belongsTo(RecipeCategory::class, 'recipe_category_id');
    }

    public function groceryLists()
    {
        return $this->belongsToMany(GroceryList::class);
    }
}
