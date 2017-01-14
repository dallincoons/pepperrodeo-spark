<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Itemable;
use App\Traits\Copyable;

class Recipe extends Model
{
    use Itemable, Copyable;

    public $timestamps = true;
    private $foreignKey = 'recipe_id';

    protected $fillable = array('user_id', 'title', 'directions', 'recipe_category_id');

    protected $appends = ['category_name'];

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

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function populateItems(array $items)
    {
        foreach($items as $itemJson)
        {
            if(data_get($itemJson, 'department_id') < 0){
                if(!$department = Department::where('name', data_get($itemJson, 'department_name'))->first()){
                    $department = Department::create([
                        'user_id' => \Auth::user()->getKey(),
                        'name'    => data_get($itemJson, 'department_name')
                    ]);
                }
                $itemJson['department_id'] = $department->getKey();
            };
            $item = Item::create($itemJson);

            $this->items()->save($item);
        }
        return $this;
    }
}
