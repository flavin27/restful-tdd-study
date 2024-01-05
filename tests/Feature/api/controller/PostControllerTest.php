<?php

namespace Tests\Feature\api\controller;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_index_should_return_json() {

        $post = Post::factory()->create();

        $payload = [
            'title' => $post->title,
            'content' => $post->content,
        ];

        $this->post('/api/posts', $payload);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);

        $response->assertJson([
            'posts' => [
                [
                    'title' => $post->title,
                    'content' => $post->content,
                ]
            ]
        ]);
    }

    public function test_post_should_be_created() {
        $payload = [
            'title' => 'test',
            'content' => 'content test',
        ];

        $response = $this->postJson('/api/posts', $payload);

        $response->assertStatus(201);

        $response->assertJson([
            'post' => [
                'title' => 'test',
                'content' => 'content test',
            ]
        ]);
    }
    public function test_post_should_be_found() {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200);

        $response->assertJson([
            'post' => [
                'title' => $post->title,
                'content' => $post->content,
            ]
        ]);
    }
    public function test_post_should_be_updated() {
        $post = Post::factory()->create();

        $payload = [
            'title' => 'test updated',
            'content' => 'content test updated',
        ];

        $response = $this->putJson('/api/posts/' . $post->id, $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'post' => [
                'title' => 'test updated',
                'content' => 'content test updated',
            ]
        ]);
    }

    public function test_post_should_return_404_if_not_found() {
        $response = $this->getJson('/api/posts/1');

        $response->assertStatus(404);

        $response->assertJson([
            'error' => [
                'code' => 404,
                'message' => 'Post not found'
            ]
        ]);
    }
}

