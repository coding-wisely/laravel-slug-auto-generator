<?php

namespace CodingWisely\SlugGenerator\Tests;

use CodingWisely\SlugGenerator\SlugGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

// Assumes SlugGenerator is a trait and not a Laravel Facade


class SlugGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_a_unique_slug()
    {
        $title = 'Existing Title';

        // Create the first entry in test_models with the slug
        $model1 = TestModel::create(['title' => $title, 'slug' => Str::slug($title)]);
        $this->assertEquals('existing-title', $model1->slug);

        // Create another model with the same title
        $model2 = TestModel::create(['title' => $title, 'slug' => Str::slug($title)]);
        $this->assertEquals('existing-title-1', $model2->slug);
        // Ensure that the two models have different slugs
        $this->assertNotEquals($model1->slug, $model2->slug);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Database setup
        Schema::create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
        });
    }
}
class TestModel extends \Illuminate\Database\Eloquent\Model {
    use SlugGenerator;

    protected $table = 'test_models';
    protected $guarded = [];
    public $timestamps = false;

    public static function getSluggableField()
    {
        return 'title';
    }
}
