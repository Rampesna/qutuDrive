<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function questions()
    {
        return $this->hasMany(FormQuestion::class, 'form_id', 'id');
    }
}
