<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'relation');
    }

    public function subTasks()
    {
        return $this->hasMany(SubTask::class)->orderBy('order');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'relation');
    }

    public function priority()
    {
        return $this->belongsTo(TaskPriority::class, 'priority_id', 'id');
    }
}
