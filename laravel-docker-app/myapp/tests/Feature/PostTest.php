<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_posts()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/posts');
        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts');
    }

    public function test_authenticated_user_can_create_post()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Post',
        'content' => 'This is a test post.'
    ]);

    $post = Post::first();
    $response->assertRedirect("/posts/{$post->id}");
    $this->assertDatabaseHas('posts', [
        'title' => 'Test Post',
        'user_id' => $user->id,
    ]);
}
    
    public function test_guest_cannot_create_post()
    {
        $response = $this->post('/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_post_validation()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/posts', [
            'title' => '',
            'content' => '',
        ]);
        $response->assertSessionHasErrors(['title', 'content']);
    }

    public function test_user_can_view_a_single_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/posts/{$post->id}");

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post');
    }

    public function test_user_can_update_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->put("/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);

        $response->assertRedirect("/posts/{$post->id}");
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_user_cannot_update_others_post()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($otherUser)->put("/posts/{$post->id}", [
            'title' => 'Hacked Title',
            'content' => 'Hacked content.',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $post->title,
        ]);
    }

   public function test_owner_can_delete_their_post()
{
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete("/posts/{$post->id}");

    $response->assertRedirect('/posts');
    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
}

    public function test_user_cannot_delete_other_post()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

         $response = $this->actingAs($otherUser)->delete("/posts/{$post->id}");

         $response->assertStatus(403);
         $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
        
}