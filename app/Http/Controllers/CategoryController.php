<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\CategoryRequestUpdate;
use App\Http\Resources\CategoryResource;
use App\Repositories\Category\CategoryInterface;
use App\Services\ApiResponseService;
use App\Traits\RegisterLogs;

class CategoryController extends Controller
{
    use RegisterLogs;
    public function __construct(
        private readonly CategoryInterface $category_repository,
    ) {}


    public function index()
    {
        $categories = $this->category_repository->get();
        return ApiResponseService::success('Datos Obtenidos', CategoryResource::collection($categories));
    }



    public function store(CategoryRequest $request)
    {
        $category = $this->category_repository->save(null, $request->validated());
        return ApiResponseService::create('Categoria Creada Correctamente.',  new CategoryResource($category));
    }


    public function show(int $id)
    {
        try {
            $category = $this->category_repository->getById(where: [], id: $id);
            return ApiResponseService::success('Datos Obtenidos', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }


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


    public function destroy(int $id)
    {
        try {
            $category = $this->category_repository->delete(id: $id);
            return ApiResponseService::create('Categoria Eliminada Correctamente.',  null);
        } catch (\Exception $e) {
            return $this->log($e);
        }
    }
}
