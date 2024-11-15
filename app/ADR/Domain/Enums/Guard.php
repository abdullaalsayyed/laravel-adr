<?php

namespace App\ADR\Domain\Enums;

enum Guard: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
