<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\ProductRequestUpdate;
use App\Http\Resources\ProductResource;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Product\ProductInterface;
use App\Services\ApiResponseService;
use App\Services\UploadService;
use App\Traits\RegisterLogs;

class ProductController extends Controller
{

    use RegisterLogs;
    public function __construct(
        private readonly ProductInterface $product_repository,
        private readonly CategoryInterface $category_repository,

    ) {}


    public function index()
    {
        $products = $this->product_repository->get();
        return ApiResponseService::success('Datos Obtenidos', ProductResource::collection($products));
    }


    public function store(ProductRequest $request)
    {
        try {
            $category = $this->category_repository->getById(where: [], id: $request->category_id);
            $image_upload = null;
            if (isset($request->image)) {
                $image_upload = UploadService::upload($request->image, 'public');
            }
            $data = $request->validated();
            $data['image'] = $image_upload;

            $product = $this->product_repository->save(null, $data);
            return ApiResponseService::create('Producto Creada Correctamente.',  new ProductResource($product));
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }


    public function show(int $id)
    {
        try {
            $product = $this->product_repository->getById(where: [], id: $id);
            return ApiResponseService::success('Datos Obtenidos', new ProductResource($product));
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }


    public function update(ProductRequestUpdate $request, int $id)
    {
        try {

            $product_exists = $this->product_repository->getById(where: [], id: $id);

            $image_upload = null;
            if (isset($request->image)) {
                $image_upload = UploadService::upload($request->image, 'public');
            }
            $data = $request->validated();
            $data['image'] = $image_upload;

            $product = $this->product_repository->save($product_exists, $data);
            return ApiResponseService::create('Producto Actualizada Correctamente.',  new ProductResource($product));
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }


    public function destroy(int $id)
    {
        try {
            $product = $this->product_repository->delete(id: $id);
            return ApiResponseService::create('Producto Eliminada Correctamente.',  null);
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }
}
