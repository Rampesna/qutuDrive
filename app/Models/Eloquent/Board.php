<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use HasFactory, SoftDeletes;

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
