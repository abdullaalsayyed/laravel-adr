<?php

namespace App\Modules\Users\Domain\Services\Enums;

enum AuthError: string
{
    case INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
    case INACTIVE_USER = 'INACTIVE_USER';
}
