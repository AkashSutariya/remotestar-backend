<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Website;
use Illuminate\Testing\Fluent\AssertableJson;

class WebsiteTest extends TestCase
{
    /**
     * A get all webite api test.
     *
     * @return void
     */
    public function test_index_response()
    {
        $websites = Website::all();

        $response = $this->getJson('/api/websites');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', $websites->count())
        );
    }
}
