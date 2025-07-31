<?php

namespace App\Application\Book\Enum;

enum BookTypeEnum: string
{
    case GRAPHIC = "graphic";
    case DIGITAL = "digital";
    case PRINT   = "print";

    public static function getValues(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
