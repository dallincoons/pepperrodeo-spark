<?php

namespace App\Repositories;

interface DepartmentRepository
{
    public function getAll();

    public function store($data);

    public function update($department, $data);
}
