<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'responsible_person_id' => 'nullable|integer', // 需要用户系统
            'due_date' => 'nullable|date|after_or_equal:today',
            'status' => 'nullable|max:50',
            'priority' => 'nullable|max:10',
        ]);

        return Task::create($request->all());
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'name' => 'nullable|max:255',
            'description' => 'nullable',
            'responsible_person_id' => 'nullable|integer', // 需要用户系统
            'due_date' => 'nullable|date|after_or_equal:today',
            'status' => 'nullable|max:50',
            'priority' => 'nullable|max:10',
        ]);

        $task->update($request->all());
        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}