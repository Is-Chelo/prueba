<?php

namespace App\Traits;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait CRUDOperations
{
    public function model(): Model
    {
        return app($this->model); // intanciamos un model con app();
    }

    public function paginate(array $where = [], array $count = [], array $relationships = [], int $per_page = 10): LengthAwarePaginator
    {
        $query = $this->model::query();

        foreach ($where as $field => $value) {
            $query->where($field, $value);
        }

        $query->with($relationships)
            ->withCount($count);

        return $query->paginate($per_page);
    }

    public function get(array $where = [], array $relationships = [], int $limit = null): Collection
    {
        $query = $this->model::query();

        foreach ($where as $field => $value) {
            $query->where($field, $value);
        }
        $query->with($relationships);

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function first(array $where = [], array $relationships = []): ?Model
    {
        $query = $this->model::query();

        foreach ($where as $field => $value) {
            $query->where($field, $value);
        }
        $query->with($relationships);

        return $query->first();
    }

    public function pluck(array $where = [], array $relationships = [],  string $pluck = 'id')
    {
        $query = $this->model::query();

        foreach ($where as $field => $value) {
            $query->where($field, $value);
        }
        $query->with($relationships);

        return $query->pluck($pluck);
    }

    public function getById(array $where = [], int $id, array $relationships = []): ?Model
    {
        $model = $this->model::with($relationships)->where('id', $id)->first();
        if ($model == null) throw new NotFoundException('Id inválido.');
        return $model;
    }

    public function delete(int $id)
    {
        $model = $this->model::where('id', $id)->first();
        if ($model == null) throw new NotFoundException('Id inválido.');
        $this->model::where('id', $model->id)->delete();
        return $model;
    }
}
