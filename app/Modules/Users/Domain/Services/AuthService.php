<?php

namespace App\Modules\Users\Domain\Services;

use App\ADR\Domain\Enums\Guard;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Modules\Users\Domain\Models\User;
use App\Modules\Users\Domain\Repositories\UserRepository;

class AuthService
{
    /**
     * AuthService constructor
     *
     * @param UserRepository $userRepository
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @param string $guard
     */
    public function __construct(
        private readonly UserRepository          $userRepository,
        private \Illuminate\Contracts\Auth\Guard $auth,
        private readonly string                  $guard = Guard::USER->value,
    ) {
        $this->auth = Auth::guard($this->guard);
    }

    /**
     * Create token
     *
     * @param User $user
     * @return string
     */
    public function createToken(User $user): string
    {
        return JWTAuth::fromUser($user);
    }

    /**
     * Login user
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function login(string $email, string $password): ?User
    {
        $credentials = ['email' => $email, 'password' => $password];

        $token = $this->auth->attempt($credentials);

        if (! $token) {

            $user = $this->userRepository->findByEmail($email);

            if ($user) {
                event(new Failed($this->guard, $user, $credentials));
            }

            return null;
        }

        $user = $this->userRepository->find($this->auth->id());

        event(new Login($this->guard, $user, false));

        return $user;
    }

    public function register(array $data)
    {
        //
    }

    public function resetPassword(array $data)
    {
        //
    }

    public function forgotPassword(array $data)
    {
        //
    }
}
