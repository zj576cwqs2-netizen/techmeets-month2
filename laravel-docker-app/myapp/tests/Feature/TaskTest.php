<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_task_list()
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/tasks');

        $response->assertStatus(200);
        $response->assertViewIs('tasks_index');
        $response->assertViewHas('tasks');
    }

    public function test_authenticated_user_can_create_task()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
        ]);

        $task = Task::first();
        $response->assertRedirect("/tasks/{$task->id}");
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
        ]);
    }

    public function test_guest_cannot_create_task()
    {
        $response = $this->post('/tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_task_validation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_user_can_view_a_single_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->get("/tasks/{$task->id}");

        $response->assertStatus(200);
    }

    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->put("/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated description.',
        ]);

        $response->assertRedirect("/tasks/{$task->id}");
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}