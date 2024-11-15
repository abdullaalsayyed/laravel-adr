<?php

namespace App\Modules\Users\Actions\V1;

use App\ADR\BaseAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Users\Domain\Services\AuthService;
use App\Modules\Users\Domain\Services\Enums\AuthError;
use App\Modules\Users\Responders\Resources\UserResource;

#[Prefix('auth')]
class LoginAction extends BaseAction
{
    public function __construct(
        private readonly AuthService $authService,
    )
    {
        parent::__construct();
    }

    #[Post('login')]
    public function __invoke(Request $request): JsonResponse
    {
        list('email' => $email, 'password' => $password) = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->authService->login($email, $password);

        if (! $user || $user->isDeleted()) {
            return $this->responder->respondWithError(
                status: AuthError::INVALID_CREDENTIALS,
                httpStatus: Response::HTTP_UNAUTHORIZED
            );
        }

        if ($user->isInactive()) {
            return $this->responder->respondWithError(
                status: AuthError::INACTIVE_USER,
                httpStatus: Response::HTTP_FORBIDDEN
            );
        }

        return $this->responder->respondWithData([
            'user' => new UserResource($user),
            'token' => $this->authService->createToken($user),
        ]);
    }
}
