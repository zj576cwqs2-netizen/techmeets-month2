<?php
namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private TaskService $taskService
    ) {}

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return view('tasks_index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'nullable',
        ]);
        $validated['user_id'] = Auth::id();

        $task = $this->taskService->createTask($validated);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'タスクを作成しました');
    }

    public function show(int $id)
    {
        $task = $this->taskService->getTaskById($id);
        return view('tasks.show', compact('task'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'nullable',
        ]);

        $task = $this->taskService->updateTask($id, $validated);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'タスクを更新しました');
    }

    public function destroy(int $id)
    {
        $this->taskService->deleteTask($id);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'タスクを削除しました');
    }
}