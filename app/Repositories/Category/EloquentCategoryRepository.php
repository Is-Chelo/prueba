<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Traits\CRUDOperations;
use Exception;
use Illuminate\Support\Facades\DB;

class EloquentCategoryRepository implements CategoryInterface
{
    use CRUDOperations;

    protected $model = Category::class;

    public function save(?Category $category, array $data)
    {
        DB::beginTransaction();
        try {
            if ($category instanceof Category) {
                $category->nombre = isset($data['nombre']) ? $data['nombre'] : $category->nombre;
                $category->descripcion = isset($data['descripcion']) ? $data['descripcion'] : $category->descripcion;
                $category->save();
            } else {
                $category = $this->model::create([
                    'nombre' => $data['nombre'],
                    'descripcion' => $data['descripcion'],
                ]);
            }
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
