<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment_on_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post("/posts/{$post->id}/comments", [
            'body' => 'とても良い投稿ですね!',
        ]);

        $response->assertRedirect("/posts/{$post->id}");
        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'とても良い投稿ですね!',
        ]);
    }

    public function test_guest_cannot_comment_on_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->post("/posts/{$post->id}/comments", [
            'body' => 'とても良い投稿ですね!',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_requires_body()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post("/posts/{$post->id}/comments", [
            'body' => '',
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_post_show_page_displays_comments()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $post->comments()->create([
            'user_id' => $user->id,
            'body' => '既存のコメントです',
        ]);

        $response = $this->actingAs($user)->get("/posts/{$post->id}");

        $response->assertStatus(200);
        $response->assertViewHas('comments');
    }
}

