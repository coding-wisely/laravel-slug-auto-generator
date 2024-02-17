<?php

namespace CodingWisely\SlugGenerator\Commands;

use Illuminate\Console\Command;

class SlugGeneratorCommand extends Command
{
    public $signature = 'laravel-slug-auto-generator';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
