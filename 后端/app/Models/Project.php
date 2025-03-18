<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'content',
        'parent_id',
        'responsible_person_id',
        'start_date',
        'end_date',
        'status',
        'priority',
    ];

    public function subprojects(): HasMany
    {
        return $this->hasMany(Project::class, 'parent_id');
    }

    public function parentProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'parent_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // 如果有用户模型
    // public function responsiblePerson(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'responsible_person_id');
    // }
}