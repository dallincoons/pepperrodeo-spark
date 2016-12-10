<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $fillable = ['name', 'user_id'];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
