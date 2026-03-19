<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UniqueSlug
{
    /**
     * @param  class-string<Model>  $modelClass
     */
    public static function make(string $modelClass, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug(Str::limit($title, 80, ''));
        $slug = $base !== '' ? $base : Str::random(10);

        $query = $modelClass::query()->where('slug', $slug);
        if ($ignoreId !== null) {
            $query->whereKeyNot($ignoreId);
        }

        if (! $query->exists()) {
            return $slug;
        }

        $suffix = 2;
        while (true) {
            $candidate = "{$slug}-{$suffix}";
            $query = $modelClass::query()->where('slug', $candidate);
            if ($ignoreId !== null) {
                $query->whereKeyNot($ignoreId);
            }
            if (! $query->exists()) {
                return $candidate;
            }
            $suffix++;
        }
    }
}

