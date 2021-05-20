<?php

use App\Support\Contracts\Xmlable;
use App\Support\Writers\XmlWriter;
use Illuminate\Support\Facades\File;

class XmlWriterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->useStoragePath('tests/storage');
    }
   /**
     * @test
     */
    public function writer_can_create_json_files()
    {
        $writer = (new XmlWriter(new class implements Xmlable {
            public function toXml(): string
            {
                return "<root><hello>World</hello></root>";
            }
        }, storage_path(date('Ymd'))));
        $writer->write();
        $this->assertFileExists($writer->getFilename());
        $contents = file_get_contents($writer->getFilename());
        $this->assertEquals($writer->toConvert(), $contents);
        File::delete($writer->getFilename());
    }
}
