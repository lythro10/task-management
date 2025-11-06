<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
{
    if (Auth::id() !== $project->owner_id) {
        abort(403, 'Unauthorized action. You must be the project owner to add tasks.');
    }

    //  Validation
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date',
        'assigned_to' => ['required', 'exists:users,id'],
        'status' => [
            'required',
            Rule::in([
                Task::STATUS_PENDING,
                Task::STATUS_IN_PROGRESS,
                Task::STATUS_COMPLETED,
            ]),
        ],
       
    ]);

    $project->tasks()->create([
        'title' => $validated['title'],
        'description' => $validated['description'] ?? null,
        'due_date' => $validated['due_date'] ?? null,
        'assigned_to' => $validated['assigned_to'],
        'status' => $validated['status'],
    ]);

    return redirect()->route('projects.show', $project)->with('success', 'Task created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
