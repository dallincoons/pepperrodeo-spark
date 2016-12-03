<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $guarded = [];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
