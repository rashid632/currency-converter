<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConvertCurrencyTest extends TestCase
{
    /**
     * Convert currency test.
     *
     * @return void
     */
    public function testConvertCurrencyTest()
    {
        $response = $this->json('GET', '/api/currency', ['']);

        $response
            ->assertStatus(200)
            ->json([]);
    }
}
