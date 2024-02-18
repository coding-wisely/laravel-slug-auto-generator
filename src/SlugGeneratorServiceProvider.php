<?php

namespace CodingWisely\SlugGenerator;

use CodingWisely\SlugGenerator\Commands\SlugGeneratorCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SlugGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-slug-auto-generator')
            ->hasConfigFile();
    }
}
