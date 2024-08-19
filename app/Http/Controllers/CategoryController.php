<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\CategoryRequestUpdate;
use App\Http\Resources\CategoryResource;
use App\Repositories\Category\CategoryInterface;
use App\Services\ApiResponseService;
use App\Traits\RegisterLogs;

/**
 * @group Categorias
 *
 */
class CategoryController extends Controller
{
    use RegisterLogs;
    public function __construct(
        private readonly CategoryInterface $category_repository,
    ) {}


    /**
     * Listado de las Categorias
     *
     * Obtiene los datos de las categorias
     *
     * @responseFile 200 responses/category/get-categories.json
     *
     */
    public function index()
    {
        $categories = $this->category_repository->get();
        return ApiResponseService::success('Datos Obtenidos', CategoryResource::collection($categories));
    }


    /**
     * Crear una Categoria
     *
     * Endpoint para crear una categoria
     *
     * @responseFile 201 responses/category/get-category.json
     *
     * @bodyParam nombre string required
     * Nombre de la categoria que deseamos crear Example: Ropa
     *
     * @bodyParam descripcion
     * Descripcon de la categoria Example: Ropa para todo tipo de edad
     *
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->category_repository->save(null, $request->validated());
        return ApiResponseService::create('Categoria Creada Correctamente.',  new CategoryResource($category));
    }

    /**
     * Obtiene una Categoria
     *
     * Obtiene una categoria por ID
     *
     * @responseFile 200 responses/category/get-category.json
     *
     * @pathParam id
     * Id de la categoria que deseamos obtener Example: 1
     *
     */
    public function show(int $id)
    {
        try {
            $category = $this->category_repository->getById(where: [], id: $id);
            return ApiResponseService::success('Datos Obtenidos', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }


    /**
     * Actualizar una Categoria
     *
     * Endpoint para actualizar una categoria
     *
     * @responseFile 201 responses/category/get-category.json
     *
     * @pathParam id
     * Id de la categoria que deseamos actualizar Example: 1
     *
     */
    public function update(CategoryRequestUpdate $request, int $id)
    {
        try {
            $category_exists = $this->category_repository->getById(where: [], id: $id);

            $category = $this->category_repository->save($category_exists, $request->validated());
            return ApiResponseService::create('Categoria Actualizada Correctamente.',  new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }

    /**
     * Eliminar una Categoria
     *
     * Endpoint para elimiar una categoria
     *
     * @responseFile 200
     *
     * @pathParam id
     * Id de la categoria que deseamos elimiar Example: 1
     *
     */
    public function destroy(int $id)
    {
        try {
            $category = $this->category_repository->delete(id: $id);
            return ApiResponseService::success('Categoria Eliminada Correctamente.',  null);
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }
}
