<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSubmit extends BaseModel
{
    use HasFactory, SoftDeletes;

    function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    function question()
    {
        return $this->belongsTo(FormQuestion::class, 'question_id', 'id');
    }
}
