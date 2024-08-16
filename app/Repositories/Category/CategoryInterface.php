<?php

namespace App\MobileApp\Repositories\Offer;

use App\Models\Category;

interface CategoryInterface
{
    public function model();

    public function get(array $where = [], array $relationships = [], int $limit = null, ?array $filter = []);

    public function first(array $where = [], array $relationships = []);

    public function save(?Category $category, array $data);

    public function delete(?Category $category);
}
