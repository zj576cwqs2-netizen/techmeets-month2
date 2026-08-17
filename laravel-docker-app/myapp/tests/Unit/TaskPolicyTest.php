<?php
namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class TaskPolicyTest extends TestCase
{
    use RefreshDatabase;

    private TaskPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new TaskPolicy();
    }
    
    public function test_view_any_returns_false()
{
    $user = User::factory()->create();
    $this->assertFalse($this->policy->viewAny($user));
}
    public function test_view_returns_false()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $this->assertFalse($this->policy->view($user, $task));
    }

    public function test_create_returns_false()
    {
        $user = User::factory()->create();
        $this->assertFalse($this->policy->create($user));
    }

     public function test_update_returns_false_because_task_has_no_owner()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $this->assertFalse($this->policy->update($user, $task));
    }

    public function test_delete_returns_false_because_task_has_no_owner()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $this->assertFalse($this->policy->delete($user, $task));
    }

    public function test_restore_returns_false()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $this->assertFalse($this->policy->restore($user, $task));
    }

    public function test_force_delete_returns_false()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $this->assertFalse($this->policy->forceDelete($user, $task));
    }
}



