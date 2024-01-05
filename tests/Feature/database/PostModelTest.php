<?php

namespace Tests\Feature\database;


use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use DatabaseMigrations;


    public function test_post_can_be_create() {
        Post::factory()->create([
            'title' => 'test',
            'content' => 'content test',
        ]);

        $this->assertDatabaseCount('posts', 1);

        $this->assertDatabaseHas('posts', [
            'title' => 'test',
            'content' => 'content test',
        ]);
    }

    public function test_can_create_multiple_posts() {
        Post::factory()->count(10)->create();

        $this->assertDatabaseCount('posts', 10);
    }
}
