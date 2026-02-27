<?php

declare(strict_types=1);

namespace App\Enums;

enum TransferStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
