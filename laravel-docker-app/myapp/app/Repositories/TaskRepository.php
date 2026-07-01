<?php

namespace App\Repositories;
use App\Models\Task;

class TaskRepository
{
    public function getall()
    {
        return Task::latest()->paginate(10);
    }

    public function findById(int $id)
    {
        return Task::findOrFail($id);
    }

    public function getPUblished()
    {
        return Task::where('status', 'published')
            ->latest()
            ->paginate(10);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }
}