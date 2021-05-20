<?php

use App\Support\Writers\JsonWriter;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\File;

class JsonWriterTest extends TestCase
{
    /**
     * @test
     */
    public function writer_can_create_json_files()
    {
        $writer = (new JsonWriter(new class implements Jsonable {
            public function toJson($options = 0)
            {
                return json_encode([ "hello" => "world" ]);
            }
        }, storage_path(date('Ymd'))));
        $writer->write();
        $this->assertFileExists($writer->getFilename());
        $contents = file_get_contents($writer->getFilename());
        $this->assertEquals($writer->toConvert(), $contents);
        File::delete($writer->getFilename());
    }
}
