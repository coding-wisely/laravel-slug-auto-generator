<?php

namespace CodingWisely\SlugGenerator\Tests;

use CodingWisely\SlugGenerator\SlugGenerator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $model1 = TestModel::create(['title' => $title]);
        $this->assertEquals('existing-title', $model1->slug);

        // Create another model with the same title;
        // let the SlugGenerator trait handle the slug creation
        $model2 = TestModel::create(['title' => $title]);
        $this->assertEquals('existing-title-1', $model2->slug);
        // Ensure that the two models have different slugs
        $this->assertNotEquals($model1->slug, $model2->slug);

        $model3 = TestModel::create(['title' => 'Groupable Title', 'groupable_field' => 1]);
        $this->assertEquals('groupable-title', $model3->slug);

        // Create another model with the same title and groupable_field;
        // let the SlugGenerator trait handle the slug creation
        $model4 = TestModel::create(['title' => $title, 'groupable_field' => 1]);
        $this->assertEquals('existing-title', $model4->slug);

        $model5 = TestModel::create(['title' => $title]);
        $this->assertEquals('existing-title-1', $model5->slug);


        $model6 = TestModel::create(['title' => 'Groupable Title', 'groupable_field' => 1]);
        $this->assertEquals('groupable-title-1', $model6->slug);
    }
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => 'cw-slug-generator-test-',
        ]);

        // Database setup
        Schema::create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('groupable_field')->nullable();
        });
    }
}
class TestModel extends \Illuminate\Database\Eloquent\Model
{
    use SlugGenerator;

    protected $table = 'test_models';

    protected $fillable = [
        'title',
        'slug',
        'groupable_field',
    ];

    public $timestamps = false;

    public static function getSluggableField()
    {
        return 'title';
    }
    public static function getGroupableField()
    {
        return 'groupable_field';
    }
}
