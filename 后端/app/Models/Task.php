<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'responsible_person_id',
        'due_date',
        'status',
        'priority',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // 如果有用户模型
    // public function responsiblePerson(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'responsible_person_id');
    // }
}