<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Project extends BaseModel
{
    use HasFactory, SoftDeletes, HasRelationships;

    protected $appends = [
        'progress'
    ];

    public function company()
    {
        return $this->belongsTo(Firmalar::class, 'company_id', 'ID');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id', 'id');
    }

    public function boards()
    {
        return $this->hasMany(Board::class)->orderBy('order');
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Board::class)->orderBy('order');
    }

    public function subTasks()
    {
        return $this->hasManyDeep(SubTask::class, [Board::class, Task::class]);
    }

    public function managementSubTasks()
    {
        return $this->hasManyDeep(SubTask::class, [Board::class, Task::class]);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'relation');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'relation');
    }

    public function users()
    {
        return $this->belongsToMany(Kullanicilar::class, 'project_user', 'project_id', 'user_id', 'id', 'ID');
    }

    public function getProgressAttribute()
    {
        return number_format($this->subTasks->count() > 0 ? $this->subTasks->where('checked', 1)->count() * 100 / $this->subTasks->count() : 100, 2);
    }
}
