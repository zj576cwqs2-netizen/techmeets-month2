<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    private PostPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PostPolicy();
    }

    public function test_view_any_returns_false()
    {
        $user = User::factory()->create();
        $this->assertFalse($this->policy->viewAny($user));
    }

    public function test_view_returns_false()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this->assertFalse($this->policy->view($user, $post));
    }

    public function test_create_returns_false()
    {
        $user = User::factory()->create();
        $this->assertFalse($this->policy->create($user));
    }

    public function test_owner_can_update()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->assertTrue($this->policy->update($user, $post));
    }

    public function test_non_owner_cannot_update()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);
        $this->assertFalse($this->policy->update($otherUser, $post));
    }

    public function test_owner_can_delete()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->assertTrue($this->policy->delete($user, $post));
    }

    public function test_restore_returns_false()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this->assertFalse($this->policy->restore($user, $post));
    }

    public function test_force_delete_returns_false()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $this->assertFalse($this->policy->forceDelete($user, $post));
    }
}