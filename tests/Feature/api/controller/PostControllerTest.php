<?php

namespace Tests\Feature\api\controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function test_get_index_should_return_json() {

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => 'something'
        ]);
    }
}
