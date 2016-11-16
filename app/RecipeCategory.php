<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Recipe;

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
}
