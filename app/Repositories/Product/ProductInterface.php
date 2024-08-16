<?php

namespace App\Repositories\Product;

use App\Models\Product;

interface ProductInterface
{
    public function model();

    public function get(array $where = [], array $relationships = [], int $limit = null);

    public function getById(array $where = [], int $id, array $relationships = []);

    public function first(array $where = [], array $relationships = []);

    public function save(?Product $product, array $data);

    public function delete(int $id);
}
