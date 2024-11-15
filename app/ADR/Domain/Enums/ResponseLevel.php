<?php

namespace App\ADR\Domain\Enums;

enum ResponseLevel: string {
    case INFO = 'INFO';
    case WARNING = 'WARNING';
    case ERROR = 'ERROR';
    case SERVER_ERROR = 'SERVER_ERROR';
    case INTEGRATION_ERROR = 'INTEGRATION_ERROR';
}
