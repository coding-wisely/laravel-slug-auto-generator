<?php

namespace CodingWisely\SlugGenerator;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait SlugGenerator
{
    public static function bootSlugGenerator(): void
    {
        static::saving(function ($model) {
            $field = self::getSluggableField();

            if (! in_array($field, array_keys($model->getAttributes()))) {
                throw new InvalidArgumentException("{$field} does not exist in the model.");
            }

            $slug = $model->slug ? $model->slug : Str::slug($model->{$field});
            $model->slug = $model->generateUniqueSlug($slug);
        });
    }

    protected static function getSluggableField(): string
    {
        return config('sluggenerator.sluggable_field') ?? 'name';
    }

    public function generateUniqueSlug(string $slug): string
    {
        // Check if the slug already has a number at the end
        $originalSlug = $slug;
        $slugNumber = 0;

        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            $slugNumber = $matches[1];
            $slug = Str::replaceLast("-$slugNumber", '', $slug);
        }

        $existingSlugs = $this->getExistingSlugs($slug, $this->getTable());

        if (! in_array($slug, $existingSlugs)) {
            return $slug.($slugNumber ? "-$slugNumber" : '');
        }

        $i = $slugNumber ? ($slugNumber + 1) : 1;
        $uniqueSlugFound = false;

        while (! $uniqueSlugFound) {
            $newSlug = $slug.'-'.$i;

            if (! in_array($newSlug, $existingSlugs)) {
                // Unique slug found
                return $newSlug;
            }

            $i++;
        }

        return $originalSlug.'-'.mt_rand(1000, 9999);
    }

    private function getExistingSlugs(string $slug, string $table): array
    {
        return $this->where('slug', 'LIKE', $slug.'%')
            ->where('id', '!=', $this->id ?? null)
            ->pluck('slug')
            ->toArray();
    }
}
