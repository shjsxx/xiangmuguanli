<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('subprojects')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'nullable|max:50',
            'content' => 'nullable',
            'parent_id' => 'nullable|exists:projects,id',
            'responsible_person_id' => 'nullable|integer', // 需要用户系统
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|max:50',
            'priority' => 'nullable|max:10',
        ]);

        return Project::create($request->all());
    }

    public function show(Project $project)
    {
        return $project->load('subprojects', 'tasks');
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'nullable|max:255',
            'type' => 'nullable|max:50',
            'content' => 'nullable',
            'parent_id' => 'nullable|exists:projects,id',
            'responsible_person_id' => 'nullable|integer', // 需要用户系统
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|max:50',
            'priority' => 'nullable|max:10',
        ]);

        $project->update($request->all());
        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }
}