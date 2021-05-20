<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class ListingApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->useStoragePath('tests/storage');
    }
    /**
     * @test
     */
    public function not_found_when_json_database_doesnt_exist()
    {
        File::delete(storage_path('db.json'));
        $response = $this->response();
        $response->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
    /**
     * @test
     */
    public function gives_xml_response()
    {
        $this->artisan("app:convert test.csv json db");
        $response = $this->response();
        $response->assertResponseOk();

    }

    public function response()
    {
        return $this->get('/api/listings', [ 'Content-Type' => 'application/xml' ]);
    }
}
