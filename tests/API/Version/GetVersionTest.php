<?php

namespace ProwectCMS\Core\Tests\API\Heatlh;

use ProwectCMS\Core\Tests\TestCase;

class GetVersionTest extends TestCase
{
    public function testGetVersion()
    {
        $response = $this->getJson('api/version');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok',

            'packages' => [
                'core' => 'dev-master'
            ]
        ]);
    }
}