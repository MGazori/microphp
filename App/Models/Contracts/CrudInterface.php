<?php

namespace App\Models\Contracts;

interface CrudInterface
{
    // Create (interface)
    public function create(array $data): int;

    // Read (Select) Single | Multiple
    public function find(int $id): object|null;
    public function get(string|array $columns, array $where): array;

    // Update records
    public function update(array $data, array $where): int;

    //Delete
    public function delete(array $where): int;
}
