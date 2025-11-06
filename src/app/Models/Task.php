<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // /** @use HasFactory<\Database\Factories\TaskFactory> */
    // use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'due_date', 
        'status', 
        'project_id',
        'assigned_to'
    ];

    public const STATUS_PENDING     = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress'; 
    public const STATUS_COMPLETED   = 'done';

    // Get the Project that the Task belongs to.
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Get the User that this Task is assigned to.
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}
