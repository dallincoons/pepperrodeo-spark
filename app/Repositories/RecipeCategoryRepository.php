<?php

namespace App\Repositories;

interface RecipeCategoryRepository
{
    public function getAll();

    public function store($data);

    public function update($department, $data);
}
