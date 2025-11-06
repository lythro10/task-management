<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()->with('tasks')->get()->map(function ($project) {
           $taskSummary = $project->tasks->groupBy('status')->map->count();
              return [ 
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'total_tasks' => $project->tasks->count(),
                'summary' =>[
                    'pending' => $taskSummary[Task::STATUS_PENDING] ?? 0,
                    'in_progress' => $taskSummary[Task::STATUS_IN_PROGRESS] ?? 0,
                    'done' => $taskSummary[Task::STATUS_COMPLETED] ?? 0,
                ],
            ];
        });

        return Inertia::render('Dashboard', [
            'projects' => $projects,
        ]);
    }

    public function show(Project $project)
    {
        if (Auth::id() !== $project->owner_id){
            abort(403, 'Unauthorized action.');
        }
        $project->load(['tasks.assignee']);
        $project->load(['owner', 'tasks.assignee']);

        $users = \App\Models\User::select('id', 'name')->get();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'users' => $users,
            'statuses' => [
                Task::STATUS_PENDING ,
                Task::STATUS_IN_PROGRESS ,
                Task::STATUS_COMPLETED ,
            ],
        ]);
    }
}