<?php

namespace App\ADR\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ADRRepository {

    /**
     * @return Collection<Model>
     */
    public function all(): Collection;

    /**
     * @param string|int $id
     * @return Model
     */
    public function find(string|int $id): Model;

}
