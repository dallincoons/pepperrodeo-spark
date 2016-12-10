<?php

namespace App\Repositories;

use App\Entities\ItemCategory;

class EloquentDepartmentRepository implements DepartmentRepository
{
    public function getAll()
    {
        return ItemCategory::all();
    }

    public function store($data)
    {
        return ItemCategory::create($data);
    }

    public function update($department, $data)
    {
        return $department->update($data);
    }
}
