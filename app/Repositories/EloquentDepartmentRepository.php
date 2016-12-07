<?php

namespace App\Repositories;

use App\Entities\ItemCategory;

class EloquentDepartmentRepository implements DepartmentRepository
{
    public function getAll()
    {
        return ItemCategory::all();
    }
}
