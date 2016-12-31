<?php

namespace App\Entities;

use App\User;
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

    protected $fillable = array('user_id', 'title', 'directions', 'recipe_category_id');

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

    public function populateItems(array $items)
    {
        foreach($items as $itemJson)
        {
            if(data_get($itemJson, 'item_category_id') < 0){
                if(!$itemCategory = ItemCategory::where('name', data_get($itemJson, 'item_category_name'))->first()){
                    $itemCategory = ItemCategory::create([
                        'user_id' => \Auth::user()->getKey(),
                        'name'    => data_get($itemJson, 'item_category_name')
                    ]);
                }
                $itemJson['item_category_id'] = $itemCategory->getKey();
            };
            $item = Item::create($itemJson);

            $this->items()->save($item);
        }
        return $this;
    }
}
