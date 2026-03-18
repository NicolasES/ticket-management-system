<?php

namespace App\Application\DAOs;

interface DepartmentDAO
{
    /**
     * @return array<int, array{id: int, name: string}>
     */
    public function findAll(): array;
}    