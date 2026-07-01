<?php 

namespace App\Http\Controllers;

use App\Services\TaskService;
use App\Repositories\TaskRepository;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private TaskService $taskService,
        private TaskRepository $taskRepository
    ){}

    public function index()
    {
        $tasks = $this->taskRepository->getpublished();
        return view('tasks_index', compact('tasks'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $post = $this->taskService->createtask($validated);

        Task::create($validated);
        return redirect()
            ->route('tasks.show', $post)
            ->with('success', 'タスクを作成しました');
    }

    public function update(Request $request, int $id)
    {
        $this->authorize('update', 'task');
        
        $validated = $request->validate([
            'title' => 'required|max:250',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = $this->taskService->updateTask($id, $validated);

        return redirect()
            ->route('tasks.show', $post)
            ->with('success', 'タスクを更新しました');
    }

    public function show(int $id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }
}