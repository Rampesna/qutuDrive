<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaitingDatabaseBackupDownload extends Model
{
    use HasFactory, SoftDeletes;

    public function backupdosyalar()
    {
        return $this->belongsTo(BackupDosyalar::class, 'backupdosyalar_id', 'ID');
    }
}
