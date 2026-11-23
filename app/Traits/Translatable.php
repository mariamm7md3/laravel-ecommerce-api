<?php

namespace App\Traits;

trait Translatable
{
    public function translate(?array $value): ?string
    {
        if (!$value) {
            return null;
        }

        $locale = app()->getLocale();

        return $value[$locale]
            ?? $value['en']
            ?? array_values($value)[0];
    }
}
