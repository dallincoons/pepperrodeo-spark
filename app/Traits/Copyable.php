<?php
namespace App\Traits;

Trait Copyable
{
    public function copyTo($user)
    {
        $recipeClone = $this->replicate();
        $recipeClone->user_id = $user->id;
        $recipeClone->save();
    }
}