<?php

namespace Tests\Feature\api\controller;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function test_get_index_should_return_empty_array() {
        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);

        $response->assertJson([
            'posts' => []
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
    public function test_post_should_not_be_created_if_title_is_missing() {
        $payload = [
            'content' => 'content test',
        ];

        $response = $this->postJson('/api/posts', $payload);

        $response->assertStatus(422);

        $response->assertJson([
            'errors' => [
                'title' => [
                    'The title field is required.'
                ]
            ]
        ]);
    }
    public function test_post_should_not_be_created_if_content_is_missing() {
        $payload = [
            'title' => 'test',
        ];

        $response = $this->postJson('/api/posts', $payload);

        $response->assertStatus(422);

        $response->assertJson([
            'errors' => [
                'content' => [
                    'The content field is required.'
                ]
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
    public function test_post_can_update_only_title() {
        $post = Post::factory()->create();

        $payload = [
            'title' => 'test updated',
        ];

        $response = $this->putJson('/api/posts/' . $post->id, $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'post' => [
                'title' => 'test updated',
                'content' => $post->content,
            ]
        ]);
    }
    public function test_post_can_update_only_content() {
        $post = Post::factory()->create();

        $payload = [
            'content' => 'content test updated',
        ];

        $response = $this->putJson('/api/posts/' . $post->id, $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'post' => [
                'title' => $post->title,
                'content' => 'content test updated',
            ]
        ]);
    }
    public function test_post_should_return_404_if_not_found_when_updating() {
        $payload = [
            'title' => 'test updated',
            'content' => 'content test updated',
        ];
        $response = $this->putJson('/api/posts/1', $payload);

        $response->assertStatus(404);

        $response->assertJson([
            'error' => [
                'code' => 404,
                'message' => 'Post not found'
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
    public function test_post_should_be_deleted() {
        $post = Post::factory()->create();

        $response = $this->deleteJson('/api/posts/' . $post->id);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Post deleted successfully'
        ]);
    }
    public function test_post_should_return_404_if_not_found_when_deleting() {
        $response = $this->deleteJson('/api/posts/1');

        $response->assertStatus(404);

        $response->assertJson([
            'error' => [
                'code' => 404,
                'message' => 'Post not found'
            ]
        ]);
    }
}

