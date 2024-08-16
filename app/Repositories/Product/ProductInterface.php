<?php

namespace App\MobileApp\Repositories\Offer;

use App\Models\Product;

interface ProductInterface
{
    public function model();

    public function get(array $where = [], array $relationships = [], int $limit = null, ?array $filter = []);

    public function first(array $where = [], array $relationships = []);

    public function save(?Product $product, array $data);

    public function delete(?Product $product);
}
