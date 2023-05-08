<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends BaseModel
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(Kullanicilar::class, 'user_id', 'ID');
    }
}
