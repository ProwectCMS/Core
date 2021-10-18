<?php

namespace ProwectCMS\Core\Tests\API\Heatlh;

use ProwectCMS\Core\Tests\TestCase;

class GetHealthTest extends TestCase
{
    public function testGetHealth()
    {
        $response = $this->getJson('api/health');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok'
        ]);
    }
}