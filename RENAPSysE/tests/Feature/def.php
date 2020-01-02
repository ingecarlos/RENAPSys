<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class def extends TestCase
{
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function defuncionTest()
    {
    $client = static::createClient();
    $client->request($method, $url, [], [], [], json_encode($content));
    $this->assertEquals(
        200,
        $client->getResponse()
            ->getStatusCode()
    );
    }
}
