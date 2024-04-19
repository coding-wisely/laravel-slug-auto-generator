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

    protected static function getGroupableField(): ?string
    {
        return config('sluggenerator.groupable_field') ?? null;
    }

    public function generateUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $slugNumberSuffix = '';

        $existingSlugs = $this->getExistingSlugs($slug, $this->getTable(), $this->getGroupableField());

        while (in_array($slug.$slugNumberSuffix, $existingSlugs)) {
            $slugNumberSuffix = $slugNumberSuffix !== '' ? $slugNumberSuffix + 1 : 1;
        }

        return $slug.($slugNumberSuffix !== '' ? '-'.$slugNumberSuffix : '');
    }

    private function getExistingSlugs(string $slug, string $table, ?string $groupable): array
    {
        $query = $this->where('slug', 'LIKE', $slug.'%')
            ->where('id', '!=', $this->id ?? null);

        // If a groupable field is present and is not null in this model, handle grouping.
        if (! is_null($groupable) && ! is_null($this->{$groupable})) {
            $query->where($groupable, $this->{$groupable});
        }

        return $query->pluck('slug')->toArray();
    }
}
