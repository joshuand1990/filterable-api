<?php

use App\Models\ListingsResource;
use App\Support\Loaders\CsvLoader as CsvLoader;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CsvLoaderTest extends TestCase
{
    protected $loader;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->useStoragePath('tests/storage');
        $this->loader = (new CsvLoader())->setFilePath(storage_path('test.csv'))->setMapper(new ListingsResource)->load();
    }

    /**
     * @test
     */
    public function only_single_row_loaded_as_test_data()
    {
        $this->assertCount(1, $this->loader);
    }
    /**
     * @test
     */
    public function compare_first_row_in_csv_data_after_loading()
    {
        $dto = new ListingsResource;
        $dto->id = "123";
        $dto->name = "Atlantis The Palm";
        $dto->image = "https://via.placeholder.com/250x250";
        $dto->discount_percentage = "25";
        $this->assertEquals($dto, $this->loader->first());
        $this->assertEquals($dto->id, $this->loader->first()->id);
    }

    /**
     * @test
     */
    public function json_output_as_expected()
    {
        $this->assertEquals($this->loader->toJson(), '[{"id":"123","name":"Atlantis The Palm","image":"https:\/\/via.placeholder.com\/250x250","discount_percentage":"25"}]');
    }

    /**
     * @test
     */
    public function xml_output_as_expected()
    {
        $this->assertEquals($this->loader->toXml(), '<root><listing><id>123</id><name>Atlantis The Palm</name><image>https://via.placeholder.com/250x250</image><discount_percentage>25</discount_percentage></listing></root>');
    }
    /**
     * @test
     */
    public function throw_exception_for_invalid_file()
    {
        $this->expectException(FileNotFoundException::class);
        (new CsvLoader())->setFilePath(database_path('xxx.csv'))->setMapper(new ListingsResource)->load();
    }
}
