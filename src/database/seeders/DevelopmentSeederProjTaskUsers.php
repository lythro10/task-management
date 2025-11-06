<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;


class DevelopmentSeederProjTaskUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $owner = User::create([
            'name' => 'Delfi Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
        ]);

        $assignee = User::create([
            'name' => 'Task Assignee',
            'email' => 'assignee@example.com',      
            'password' => Hash::make('password'),
        ]); 

        $project = Project::create([
            'owner_id' => $owner->id,
            'name' => 'Delfi Project Management',
            'description' => 'Hi if your viewing this, then Hi Stelio!',
        ]);

        $project->tasks()->createMany([
            [
                'title' => 'Design Database Schema',
                'description' => 'Create an efficient database schema for the project management app.',
                'due_date' => now()->addDays(7),
                'status' => Task::STATUS_PENDING,
                'assigned_to' => $assignee->id,
            ],
            [
                'title' => 'Implement Authentication',
                'description' => 'Set up user authentication and authorization.',
                'due_date' => now()->addDays(14),
                'status' => Task::STATUS_IN_PROGRESS,
                'assigned_to' => $assignee->id,
            ],
            [
                'title' => 'Build Project Dashboard',
                'description' => 'Create a dashboard to display project summaries and task statuses.',
                'due_date' => now()->addDays(21),
                'status' => Task::STATUS_COMPLETED,
                'assigned_to' => $assignee->id,
            ],
        ]);
    }
}
