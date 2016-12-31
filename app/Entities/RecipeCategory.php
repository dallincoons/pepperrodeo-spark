<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function populate($data)
    {
        $this->user_id = \Auth::user()->getKey();
        $this->name = data_get($data, 'category.name');
        return $this;
    }
}
