<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
        private MailNotification $mailNotification
    ) {}

    public function getAllTasks(): Collection
    {
        return $this->taskRepository->getAll();
    }

    public function getTaskById(int $id): Task
    {
        return $this->taskRepository->findById($id);
    }

    public function createTask(array $data): Task
    {
        $task = $this->taskRepository->create($data);

        $this->mailNotification->sendTaskCreated($task);

        return $task;
    }

    public function updateTask(int $id, array $data): Task
    {
        $task = $this->taskRepository->findById($id);
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(int $id): void
    {
        $task = $this->taskRepository->findById($id);
        $this->taskRepository->delete($task);
    }
}