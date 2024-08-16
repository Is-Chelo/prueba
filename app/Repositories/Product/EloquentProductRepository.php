<?php

namespace App\Repositories\Attendance;

use App\MobileApp\Repositories\Offer\ProductInterface;
use App\Models\Product;
use App\Traits\CRUDOperations;
use Exception;
use Illuminate\Support\Facades\DB;

class EloquentProductRepository implements ProductInterface
{
    use CRUDOperations;

    protected $model = Product::class;

    public function save(?Product $product, array $data)
    {
        DB::beginTransaction();

        try {
            if ($product instanceof Product) {
                $product->category_id = isset($data['category_id']) ? $data['category_id'] : $product->category_id;
                $product->nombre = isset($data['nombre']) ? $data['nombre'] : $product->nombre;
                $product->descripcion = isset($data['descripcion']) ? $data['descripcion'] : $product->descripcion;
                $product->precio = isset($data['precio']) ? $data['precio'] : $product->precio;
                $product->cantidad = isset($data['cantidad']) ? $data['cantidad'] : $product->cantidad;
                $product->image = isset($data['image']) ? $data['image'] : $product->image;
                $product->save();
            } else {
                $product = $this->model::create([
                    'category_id' => $data['category_id'],
                    'nombre' => $data['nombre'],
                    'descripcion' => $data['descripcion'],
                    'precio' => $data['precio'],
                    'cantidad' => $data['cantidad'],
                    'image' => $data['image'],
                ]);
            }
            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
