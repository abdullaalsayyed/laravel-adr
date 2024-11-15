<?php

namespace App\ADR;

use App\ADR\Contracts\ADRRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository implements ADRRepository
{
    protected Model $model;

    /**
     * Repository constructor.
     * @param Model $model
     */
    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model::all();
    }
}
