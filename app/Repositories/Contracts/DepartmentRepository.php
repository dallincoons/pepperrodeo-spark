<?php

namespace App\Repositories\Contracts;

interface DepartmentRepository
{
    public function getAll();

    public function store($data);

    public function update($department, $data);
}
