<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function test_live_health_endpoint_returns_ok(): void
    {
        $response = $this->getJson(route('health.live'));

        $response->assertOk()->assertJson([
            'status' => 'ok',
        ]);
    }

    public function test_ready_health_endpoint_returns_ready_or_not_ready(): void
    {
        $response = $this->getJson(route('health.ready'));

        $this->assertTrue(in_array($response->status(), [200, 503], true));
    }
}

