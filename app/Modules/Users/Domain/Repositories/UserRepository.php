<?php

namespace App\Modules\Users\Domain\Repositories;

use App\ADR\BaseRepository;
use App\Modules\Users\Domain\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(
    ) {
        $this->model = new User();
        parent::__construct($this->model);
    }

    /**
     * Get user by email
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model::where('email', $email)->first();
    }

    /**
     * Get user by id
     *
     * @param string|int $id
     * @return User
     */
    public function find(string|int $id): User
    {
        return $this->model::find($id);
    }
}
