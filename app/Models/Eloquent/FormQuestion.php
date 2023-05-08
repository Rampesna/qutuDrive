<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormQuestion extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function answers()
    {
        return $this->hasMany(FormQuestionAnswer::class);
    }
}
