<?php

namespace App\Modules\Users\Enums;

enum UserTypeEnum: string
{
    case Admin = 'admin';
    case Operator = 'operator';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
