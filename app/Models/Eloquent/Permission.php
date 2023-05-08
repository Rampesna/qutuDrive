<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(Kullanicilar::class, 'user_permission', 'permission_id', 'user_id', 'id', 'ID');
    }
}
