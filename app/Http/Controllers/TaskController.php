<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // Exclude 'completed' from request data
        $taskData = $request->only(['title', 'description']);

        $task = Task::create($taskData);
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // Exclude 'completed' from request data
        $taskData = $request->only(['title', 'description']);

        $task->update($taskData);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    public function toggleComplete(Task $task)
    {
        // Toggle the 'completed' status
        $task->completed = !$task->completed;
        $task->save();

        return response()->json($task);
    }
}
