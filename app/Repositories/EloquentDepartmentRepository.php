<?php

namespace App\Repositories;

use App\Entities\Department;
use App\Repositories\Contracts\DepartmentRepository;

class EloquentDepartmentRepository implements DepartmentRepository
{
    public function getAll()
    {
        return Department::all();
    }

    public function store($data)
    {
        return Department::create($data);
    }

    public function update($department, $data)
    {
        return $department->update($data);
    }
}
