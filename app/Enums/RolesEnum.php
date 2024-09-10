<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum RolesEnum: string
{
    use EnumToArray;

    case ADMIN = 'admin';
    case USER = 'user';
    case RESTAURANT = 'restaurant';
    case STORE = 'store';

    public function className(): string
    {
        return match ($this) {
            static::ADMIN, static::USER => 'App\Models\User',
            static::RESTAURANT => 'App\Models\Restaurant',
            static::STORE => 'App\Models\Store',
        };
    }
}
