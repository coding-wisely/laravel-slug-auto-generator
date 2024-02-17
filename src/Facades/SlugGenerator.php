<?php

namespace CodingWisely\SlugGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CodingWisely\SlugGenerator\SlugGenerator
 */
class SlugGenerator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \CodingWisely\SlugGenerator\SlugGenerator::class;
    }
}
