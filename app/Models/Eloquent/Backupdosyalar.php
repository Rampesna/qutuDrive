<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Backupdosyalar
 *
 * @property int $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property float|null $DOSYABOYUTU
 * @property string|null $BACKUPTURU
 * @property string|null $BACKUPOLUSMATARIHI
 * @property string|null $VERITABANIADI
 * @property string|null $BACKUPDURUMU
 * @property string|null $ISEMRIBASLIKID
 * @property string|null $DOSYAADI
 * @property int|null $YEDEKDOSYAPARCASAYISI
 * @property float|null $ZIPDOSYABOYUTU
 *
 * @package App\Models
 */
class Backupdosyalar extends BaseModel
{
//    use SoftDeletes;

    protected $table = 'backupdosyalar';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $casts = [
        'DOSYABOYUTU' => 'float',
        'YEDEKDOSYAPARCASAYISI' => 'int',
        'ZIPDOSYABOYUTU' => 'float'
    ];

    protected $fillable = [
        'FIRMAAPIKEY',
        'KULLANICIAPIKEY',
        'DOSYABOYUTU',
        'BACKUPTURU',
        'BACKUPOLUSMATARIHI',
        'VERITABANIADI',
        'BACKUPDURUMU',
        'ISEMRIBASLIKID',
        'DOSYAADI',
        'YEDEKDOSYAPARCASAYISI',
        'ZIPDOSYABOYUTU'
    ];
}
