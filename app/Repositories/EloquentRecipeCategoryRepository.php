<?php


namespace App\Repositories;


use App\Entities\RecipeCategory;

class EloquentRecipeCategoryRepository implements RecipeCategoryRepository
{
    public function getAll()
    {
        return RecipeCategory::all();
    }

    public function store($data)
    {
        return RecipeCategory::create($data);
    }

    public function update($category, $data)
    {
        return $category->update($data);
    }
}
