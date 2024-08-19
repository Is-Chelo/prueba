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

/**
 * @group Productos
 *
 */
class ProductController extends Controller
{

    use RegisterLogs;
    public function __construct(
        private readonly ProductInterface $product_repository,
        private readonly CategoryInterface $category_repository,

    ) {}


    /**
     * Listado de las Productos
     *
     * Obtiene los datos de las productos
     *
     * @responseFile 200 responses/product/get-products.json
     *
     */
    public function index()
    {
        $products = $this->product_repository->get(relationships: ['category']);
        return ApiResponseService::success('Datos Obtenidos', ProductResource::collection($products));
    }


    /**
     * Crear un Producto
     *
     * Obtiene los datos de las productos
     *
     * @responseFile 200 responses/product/get-product.json
     *
     * @bodyParam nombre string required
     * Nombre del Producto Example: Polera Edicion 2024
     *
     * @bodyParam descripcion string required
     * Descripcion del Producto Example: Descripcion
     *
     *
     * @bodyParam category_id int required
     * categoria_id del Producto Example: 1
     *
     * @bodyParam precio float required
     * Precio del Producto Example: 10.45
     *
     * @bodyParam cantidad int required
     * Cantidad del Producto Example: 10
     *
     * @bodyParam thumbnail image required
     *
     *
     */
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


    /**
     * Obtener un producto
     *
     * Obtiene los datos de las productos
     *
     * @responseFile 200 responses/category/get-categories.json
     *
     * @pathParam id
     * Id del producto que deseamos obtener Example: 1
     *
     */
    public function show(int $id)
    {
        try {
            $product = $this->product_repository->getById(where: [], id: $id, relationships: ['category']);
            return ApiResponseService::success('Datos Obtenidos', new ProductResource($product));
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }


    /**
     * Actualizar una Producto
     *
     * Endpoint para actualizar una producto
     *
     * @responseFile 201 responses/product/get-product.json
     *
     * @pathParam id
     * Id de la producto que deseamos actualizar Example: 1
     *
     * @bodyParam nombre string required
     * Nombre del Producto Example: Polera Edicion 2024
     *
     * @bodyParam descripcion string required
     * Descripcion del Producto Example: Descripcion
     *
     *
     * @bodyParam category_id int required
     * categoria_id del Producto Example: 1
     *
     * @bodyParam precio float required
     * Precio del Producto Example: 10.45
     *
     * @bodyParam cantidad int required
     * Cantidad del Producto Example: 10
     *
     * @bodyParam thumbnail image required
     *
     */
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


    /**
     * Eliminar un Producto
     *
     * Endpoint para elimiar una producto
     *
     * @responseFile 200
     *
     * @pathParam id
     * Id de la producto que deseamos elimiar Example: 1
     *
     */
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
