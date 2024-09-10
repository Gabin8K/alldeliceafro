<?php

namespace App\Enums;

enum FileTypesEnum: string
{
    case PICTURE = 'picture';
    case CV = 'cv';

    public function label(): string
    {
        return match ($this) {
            static::PICTURE => 'Picture',
            static::CV => 'CV'
        };
    }
}
