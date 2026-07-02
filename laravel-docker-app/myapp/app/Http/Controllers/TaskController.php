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

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'nullable',
        ]);
        $post = $this->taskService->updateTask($id, $validated);

        return redirect()
            ->route('tasks.show', $post)
            ->with('success', 'タスクを更新しました');
    }

    public function destroy(int $id)
{
    $this->taskRepository->delete(
        $this->taskRepository->findById($id)
    );
    return redirect()
        ->route('tasks.index')
        ->with('success', 'タスクを削除しました');
}

public function index()
{
    $tasks = $this->taskRepository->getAll();
    return view('tasks_index', compact('tasks'));
}

public function show(int $id)
{
    $task = $this->taskRepository->findById($id);
    return view('tasks.show', compact('task'));
}
}