<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = array('quantity', 'name', 'type', 'recipe_id', 'grocery_list_id', 'department_id', 'department', 'recipe');

    protected $appends = ['recipe_id', 'department', 'recipe_title'];

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

    public function getDepartmentAttribute()
    {
        if($this->department_id){
            return Department::find($this->department_id)->name;
        }

        return null;
    }
}
