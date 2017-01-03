<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'user_id'];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    protected static function boot()
    {
        parent::boot();

        Department::deleting(function($department){
            $department->items()->delete();
        });
    }
}
