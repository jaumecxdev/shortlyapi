<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test url required.
     *
     * @return void
     */
    public function test_url_required()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer []{}()'])->postJson('/api/v1/short-urls', ['ruta' => 'www.google.com']);

        $response
            ->assertStatus(400)
            ->assertJson(["errors" => ["url" => ["The url field is required."]]]);
    }



    /**
     * A basic feature test bearer required.
     *
     * @return void
     */
    public function test_bearer_required()
    {
        $response = $this->postJson('/api/v1/short-urls', ['url' => 'www.google.com']);
        $response
            ->assertStatus(400)
            ->assertJson(["error" => "Bearer token is required"]);
    }



    /**
     * A basic feature test bad beader.
     *
     * @return void
     */
    public function test_bad_bearer1()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer {)'])->postJson('/api/v1/short-urls', ['url' => 'www.google.com']);
        $response
            ->assertStatus(400)
            ->assertJson(["error" => "Bearer token is not valid"]);
    }


    /**
     * A basic feature test bad beader.
     *
     * @return void
     */
    public function test_bad_bearer2()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer [{]}'])->postJson('/api/v1/short-urls', ['url' => 'www.google.com']);
        $response
            ->assertStatus(400)
            ->assertJson(["error" => "Bearer token is not valid"]);
    }


    /**
     * A basic feature test bad beader.
     *
     * @return void
     */
    public function test_bad_bearer3()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer (((((((()'])->postJson('/api/v1/short-urls', ['url' => 'www.google.com']);
        $response
            ->assertStatus(400)
            ->assertJson(["error" => "Bearer token is not valid"]);
    }


    /**
     * A basic feature test good tiny request.
     *
     * @return void
     */
    public function test_good_tiny_request()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer {}[]()'])->postJson('/api/v1/short-urls', ['url' => 'http://www.google.com']);
        $response->assertSuccessful();
        $headers = get_headers(json_decode($response->content())->url, 1);
        $this->assertTrue($headers['Location'] == "http://www.google.com");
    }
}
