<?php

use App\Models\ListingsResource;
use App\Support\Loaders\JsonLoader;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class JsonLoaderTest extends TestCase
{
       protected $loader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->useStoragePath('tests/storage');
        $this->loader = (new JsonLoader())->setFilePath(storage_path('test.json'))->setMapper(new ListingsResource)->load();
    }

    /**
     * @test
     */
    public function only_load_test_data()
    {
        $this->assertCount(2, $this->loader);
    }
    /**
     * @test
     */
    public function filter_by_name()
    {
        $filter = $this->loader->where('name', '=', 'Atlantis The Palm');
        $this->assertCount(1, $filter);
        $this->assertEquals($filter->toJson(), '[{"id":"123","name":"Atlantis The Palm","image":"https:\/\/via.placeholder.com\/250x250","discount_percentage":"25"}]');
        $this->assertEquals($filter->toXml(), '<root><listing><id>123</id><name>Atlantis The Palm</name><image>https://via.placeholder.com/250x250</image><discount_percentage>25</discount_percentage></listing></root>');
    }
}
