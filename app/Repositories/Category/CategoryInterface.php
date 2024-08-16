<?php

namespace App\Repositories\Category;


use App\Models\Category;

interface CategoryInterface
{
    public function model();

    public function get(array $where = [], array $relationships = [], int $limit = null);

    public function getById(array $where = [], int $id, array $relationships = []);

    public function first(array $where = [], array $relationships = []);

    public function save(?Category $category, array $data);

    public function delete(int $id);
}
